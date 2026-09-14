<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$card = App\Models\AnggotaCard::with(["anggota.user","latestBerlaku"])->find(1);
$a = $card->anggota;
echo "Nama: ".$a->nama.PHP_EOL;
echo "Card: ".$card->card_id.PHP_EOL;
$p = strtoupper(trim(preg_replace("/^\s*KORWIL\s*(PROVINSI\s*)?[-:]?\s*/i","",$card->latestBerlaku->jabatan)));
echo "Provinsi: ".$p.PHP_EOL;
