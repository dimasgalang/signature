<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Commitment Of Computer User</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 10;
      line-height: 1.5;
      max-width: 800px;
      margin: 20px auto;
      padding: 15px;
    }
    h1 {
      text-align: center;
      text-transform: uppercase;
      font-size: 20px;
      margin-bottom: 30px;
    }
    .centretable {
        /* display: flex; */
        vertical-align: center;
        text-align: center;
    }
  </style>
</head>
<body>
  <table width="100%" style="border-collapse: collapse;">
      <tr style="border-bottom: 1pt solid black;">
        <td style="border: 1px solid #000;">
            <div class="centretable">
                <img src="{{ public_path('img/chutex_logo.png') }}" style="width: 70px;">
            </div>
        </td>
        <td style="border: 1px solid #000;">
            <div class="centretable">
                <p><b>KOMITMEN PENGGUNA KOMPUTER</b></p>
                <p><b><i>Commitment Of Computer User</i></b></p>
            </div>
        </td>
        <td style="border: 1px solid #000;">
            Doc#: 02/FM-PL05<br>
            Revision: 6<br>
            Effective: 13-May-25<br>
            Page: 1/1<br>
        </td>
      </tr>
  </table>
  <br>
  <table width="100%">
    <tr>
        <td>
            <b>Tanggal/<i>Date: </i></b><br>{{ date('Y-m-d', strtotime($commitment->date)) }}
        </td>
    </tr>
    <tr>
        <td>
            <b>Nama/<i>Name: </i></b><br>{{ $commitment->name }}
        </td>
        <td>
            <b>Tanggal Masuk/<i>Joining date: </i></b><br>{{ $commitment->joining_date }}
        </td>
    </tr>
    <tr>
        <td>
            <b>ID Karyawan<i>/Employee ID: </i></b><br>{{ $commitment->npk }}
        </td>
        <td>
            <b>Departement<i>/Department: </i></b><br>{{ $commitment->dept }}
        </td>
        <td>
            <b>Posisi<i>/Position: </i></b><br>{{ $commitment->position }}
        </td>
    </tr>
  </table>

  <p>Saya ingin berkomitmen sebagai berikut / <i>I would like to commit as the follows:</i></p>
  <ol type="1" style="text-align: justify;">
    <li>Mematuhi Kebijakan Keamanan Siber Perusahaan dan peraturan Prosedur Pengendalian Akses Siber dan TI.<br>
        <i>Comply with Company’s Cyber Security Policy and the regulation of Cyber and IT Access Control Procedure.</i></li>
    <li>
        Tidak menggunakan Internet dan Email CHUTEX untuk berpartisipasi, mendukung, dan menyebarkan terorisme.<br>
        <i>Not to use Internet and Email of CHUTEX to participate, support, and disseminate terrorism.</i>
    </li>
    <li>
        Tidak menggunakan Internet dan Email CHUTEX untuk menyebarkan virus, spam, malware, atau melakukan serangan hacking ke jaringan Chutex dan/atau jaringan komputer lainnya.<br>
        <i>Not to use Internet and Email of CHUTEX to spread virus, spam, malwares, or to make hacking attacks to the Chutex and/or other computer’s networks.</i>
    </li>
    <li>
        Tidak menggunakan Internet dan Email CHUTEX untuk merusak reputasi anggota Chutex dan/atau orang dan organisasi lain.<br>
        <i>Not to use Internet and Email of CHUTEX to damage the reputation of any members of Chutex and/or other people and organizations.</i>
    </li>
    <li>
        Tidak menggunakan Internet dan Email CHUTEX untuk mendaftar dan mengakses jejaring sosial, seperti Facebook, atau tidak menggunakan aplikasi pengiriman pesan apa pun kecuali SKYPE di tempat kerja.<br>
        <i>Not to use Internet and Email of CHUTEX to register and access social networks, such as Facebook, or not use any messaging applications except for SKYPE in work.</i>
    </li>
    <li>
        Tidak mengakses file/folder data yang tidak sah untuk menyalin, menghapus, atau mengubah konten file/folder tersebut. Memiliki tanggung jawab untuk melindungi data/file data yang diberikan/ditugaskan untuk pekerjaannya sendiri. Mendapatkan persetujuan dari atasan/manajer & persetujuan dari Dewan Manajemen sebelum mengambil file data dari perusahaan.<br>
        <i>Not to access to unauthorized data files/folders to copy, delete, or modify the content of these files/folders. Have responsibility to protect the data/data file served/assigned for his/her own work. Get the acceptance from the supervisor/manager & the approval from the Management Board before taking data files out of the company.</i>
    </li>
    <li>
        Tidak mengakses aplikasi perusahaan yang tidak sah untuk menyalin, mengubah, atau menghapus data dalam aplikasi tersebut. Memiliki tanggung jawab untuk melindungi aplikasi dan datanya saat diberi wewenang untuk menggunakannya.<br>
        <i>Not to access to unauthorized company applications to copy, modify, or delete the data in these applications. Have responsibility to protect applications and their data when being authorized to use them.</i>
    </li>
    <li>
        Tidak melakukan tindakan yang merusak komputer dan perangkat IT yang menyertainya. Bertanggung jawab untuk melindungi aset perusahaan dan mengembalikannya ke departemen IT saat tidak digunakan atau sebelum meninggalkan perusahaan.<br>
        <i>Not to engage any destructive actions to computer and accompanying IT devices. Have responsibility to protect these company properties and return them to IT department when they are not in use or before leaving the company.</i>
    </li>
  </ol>
  
  <table width="100%">
    <tr>
        <td width="60%"></td>
        <td style="text-align: center;">Tanda Tangan Pengguna Komputer<br>
            <i>Signature of Computer User</i>
            <br>
            <br>
            <br>
            <br>
            <b>{{ $commitment->name }}</b>
        </td>
    </tr>
  </table>
</body>
</html>