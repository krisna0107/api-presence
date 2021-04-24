# Dokumentasi Route API

## Karyawan (Meminta Auth dari Firebase)
**GET** getKaryawanById : root/api/karyawans/{id}

**GET** getKarywanByUsers : root/api/karyawans/users/{users}  | **users** bisa di isi dengan UID / EMAIL


## Device (Meminta Auth dari Firebase)
**GET** getDeviceByImei : root/api/devices/users/{users}/no-device/{imei} | **users** di isi id, **imei** di isi dengan no imei HP


## Absensi
(Meminta Auth dari Firebase)

**GET** getNowAbsensi : root/api/absensis/user/{user_id}/device/{imei}

**GET** getAllAbsensi : root/api/absensis/user/{user_id}/device/{imei}/limit/{limit}

(Tidak Perlu Auth Firebase)

**POST** absenMasukKeluar : root/api/absensis/user/{user_id}/device/{imei}/id/{ssid}/kode/{opsi} | **users_id** di isi id, **imei** di isi dengan no imei HP, **ssid** di isi dengan ssid kantor, **limit** di isi dengan jumlah yang akan tampil
