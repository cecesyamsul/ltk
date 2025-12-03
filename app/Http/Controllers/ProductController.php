<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use SimpleExcel\SimpleExcel;
use Illuminate\Support\Facades\Storage;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');  
    }

    public function index()
    {
       
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    public function create()
    {
        return view('products.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|string|max:20',
            'stok_awal' => 'required|numeric',
            'image_type' => 'required|in:url,file',
            'image_url' => 'required_if:image_type,url|nullable|url',
            'image_file' => 'required_if:image_type,file|nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $imagePath = null;


        if ($request->image_type === 'url') {
            $imagePath = $request->image_url;
        }

        // Jika user pilih Upload File
        if ($request->image_type === 'file' && $request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('products', 'public');
            $imagePath = url('storage/' . $imagePath);
        }

        $harga = preg_replace('/[^0-9]/', '', $request->harga);
        $harga = (int) $harga;
        $stok_awal = str_replace(',', '', $request->stok_awal);
        $stok_awal = (int) $stok_awal;



        Product::create([
            'name' => $request->name,
            'harga' => $harga,
            'stok_awal' => $stok_awal,
            'stok' => $stok_awal,
            'image_url' => $imagePath, // simpan path/url
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }


    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $product = Product::findOrFail($decryptedId);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi dasar
        $request->validate([
            'name' => 'required',
            'harga' => 'required|string|max:20',
            'stok_awal' => 'required|numeric',
            'image_type' => 'required|in:url,file',
            'image_url' => 'nullable|string', // jika tipe url
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048', // jika upload file max 2MB
        ]);
        $harga = preg_replace('/[^0-9]/', '', $request->harga);
        $harga = (int) $harga;
        $stok_awal = str_replace(',', '', $request->stok_awal);
        $stok_awal = (int) $stok_awal;
        $data = [
            'name' => $request->name,
            'harga' => $harga,
            'stok_awal' => $stok_awal,
        ];



        if ($request->image_type === 'url' && $request->filled('image_url')) {
            $data['image_url'] = $request->image_url;
        } elseif ($request->image_type === 'file' && $request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function getProduk()
    {

        $query = Product::select(['id', 'name', 'harga', 'stok', 'stok_awal']);
        return DataTables::of($query)
            ->addColumn('aksi', function ($row) {
                $encryptedId = Crypt::encryptString($row->id);
                $edit = '<div class="flex gap-1"><a href="' . route('products.edit', $encryptedId) . '" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>';
                $hapus = '<form action="' . route('products.destroy', $encryptedId) . '" method="POST" class="inline-block ml-1">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button onclick="return confirm(\'Hapus produk ini?\')" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">Hapus</button>'
                    . '</form></div>';
                return $edit . ' ' . $hapus;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function importView()
    {
        return view('products.imports');
    }

    public function downloadTemplate()
    {
        $filePath = 'public/format_import_produk.xlsx'; // path di storage/app/public

        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::download($filePath, 'format_import_produk.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($request->file('file')->getPathName());
        foreach ($reader->getSheetIterator() as $sheet) {
            $rowNumber = 0;
            $successCount = 0;
            $failCount = 0;
            foreach ($sheet->getRowIterator() as $row) {
                $rowNumber++;

                // Lewati header
                if ($rowNumber === 1) continue;

                $cells = $row->getCells();

                $name = $cells[0]->getValue();
                $harga = $cells[1]->getValue();
                $stok_awal = $cells[2]->getValue();
                $stok = $cells[2]->getValue();
                $image_url = $cells[3]->getValue();

                // Validasi: semua field wajib, harga & stok integer, image_url valid
                if (
                    !empty($name) &&
                    !empty($harga) &&
                    !empty($stok_awal) &&
                    filter_var($image_url, FILTER_VALIDATE_URL) &&
                    is_numeric($harga) &&
                    is_numeric($stok)
                ) {
                    Product::create([
                        'name' => $name,
                        'harga' => (int) $harga,
                        'stok_awal' => (int) $stok_awal,
                        'stok' => (int) $stok,
                        'image_url' => $image_url,
                    ]);

                    $successCount++;
                } else {
                    $failCount++;
                }
            }
        }

        $reader->close();
        return redirect()->back()->with('success', "$successCount data berhasil diimport, $failCount data gagal diimport.");
    }
}
