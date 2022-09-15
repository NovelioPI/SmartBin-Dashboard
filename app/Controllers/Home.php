<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $builder = $db
            ->table('statustempatsampah sts')
            ->select([
                'ts.ID',
                'ts.Latitude',
                'ts.Longitude',
                'sts.WaktuAmbil',
                'js.Deskripsi'])
            ->join('tempatsampah ts', 'ts.ID = sts.ID')
            ->join('jenisstatus js', 'js.ID = sts.ID');
        
        $data['bins'] = $builder->get()->getResultArray();

        return view('home', $data);
    }
}
