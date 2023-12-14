<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataMemberTransformers extends JsonResource
{
    public function toArray($request)
    {    
        return [
            "kode_cabang" => $this->kode_cabang,
            "alamat_surat" => $this->alamat_surat,
            "kode_member" => $this->kode_member,
            "kota" => $this->kota,
            "nama" => $this->nama,
            "kelurahan" => $this->kelurahan,
            "no_ktp" => $this->no_ktp,
            "kode_pos" => $this->kode_pos,
            "alamat_ktp" => $this->alamat_ktp,
            "no_hp" => $this->no_hp,
            "tgl_lahir" => $this->tgl_lahir,
            "kota_ktp" => $this->kota_ktp,
            "jenis_outlet" => $this->jenis_outlet,
            "kelurahan_ktp" => $this->kelurahan_ktp,
            "sub_outlet" => $this->sub_outlet,
            "kode_pos_ktp" => $this->kode_pos_ktp,
            "pkp" => $this->pkp,
            "area" => $this->area,
            "telepon" => $this->telepon,
            "kredit" => $this->kredit,
            "top" => $this->top,
            "jenis_cust" => $this->jenis_cust,
            "bebas_iuran" => $this->bebas_iuran,
            "retail_khusus" => $this->retail_khusus,
            "ganti_kartu" => $this->ganti_kartu,
            "jarak" => $this->jarak,
            "limit" => $this->limit,
            "npwp" => $this->npwp,
            "blocking_pengiriman" => $this->blocking_pengiriman,
            "salesman" => $this->salesman,
            "alamat_email" => $this->alamat_email,
        ];
    }
}