<?php

namespace App\Http\Controllers;

use App\Http\Resources\GundamResource;
use App\Models\Gundam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GundamController extends Controller
{
    /**
     * Daftar Gundam
     *
     * Mengambil seluruh data Gundam. Mendukung search, filter merk,
     * filter ori (1 = ori, 0 = bukan ori), dan pagination opsional (per_page).
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:100',
            'ori' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ], $this->messages());

        $query = Gundam::query()
            ->when($request->filled('search'), fn ($q) => $q->where('nama', 'like', '%' . $request->input('search') . '%'))
            ->when($request->filled('merk'), fn ($q) => $q->where('merk', $request->input('merk')))
            ->when($request->filled('ori'), fn ($q) => $q->where('ori', $request->boolean('ori')))
            ->orderBy('id');

        $gundams = $request->filled('per_page')
            ? $query->paginate((int) $request->input('per_page'))->withQueryString()
            : $query->get();

        return GundamResource::collection($gundams)
            ->additional(['message' => 'Daftar gundam berhasil diambil']);
    }

    /**
     * Tambah Gundam
     *
     * Menambahkan unit Gundam baru ke showroom.
     */
    public function store(Request $request): GundamResource
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'merk' => 'required|string|max:100',
            'ori' => 'required|boolean',
            'harga_retail' => 'required|integer|min:0',
        ], $this->messages());

        $gundam = Gundam::create($validated);

        // Model yang baru dibuat otomatis dikirim dengan status 201 Created
        return (new GundamResource($gundam))
            ->additional(['message' => 'Data gundam berhasil ditambahkan']);
    }

    /**
     * Detail Gundam
     *
     * Mengambil detail satu Gundam berdasarkan ID.
     */
    public function show(Gundam $gundam): GundamResource
    {
        return (new GundamResource($gundam))
            ->additional(['message' => 'Detail gundam berhasil diambil']);
    }

    /**
     * Perbarui Gundam
     *
     * Memperbarui data Gundam yang sudah ada (PUT atau PATCH).
     */
    public function update(Request $request, Gundam $gundam): GundamResource
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'merk' => 'sometimes|required|string|max:100',
            'ori' => 'sometimes|required|boolean',
            'harga_retail' => 'sometimes|required|integer|min:0',
        ], $this->messages());

        $gundam->update($validated);

        return (new GundamResource($gundam))
            ->additional(['message' => 'Data gundam berhasil diperbarui']);
    }

    /**
     * Hapus Gundam
     *
     * Menghapus Gundam dari basis data.
     */
    public function destroy(Gundam $gundam): JsonResponse
    {
        $gundam->delete();

        return response()->json([
            'message' => 'Data gundam berhasil dihapus',
            'data' => null,
        ], 200);
    }

    private function messages(): array
    {
        return [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'integer' => 'Kolom :attribute harus berupa angka.',
            'boolean' => 'Kolom :attribute harus berupa true/false (true = ori, false = bukan ori).',
            'min' => 'Kolom :attribute minimal :min.',
            'max' => 'Kolom :attribute maksimal :max.',
        ];
    }
}