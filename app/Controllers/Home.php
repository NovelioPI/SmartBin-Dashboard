<?php

namespace App\Controllers;

class Home extends BaseController
{
    function __construct()
    {
        $this->db = db_connect();
    }

    private function getLatestUpdatedSubquery() 
    {
        $subquery = $this->db
            ->table('statustempatsampah')
            ->selectMax('WaktuAmbil', 'LastWaktuAmbil')
            ->groupBy('TempatSampah_ID')
            ->getCompiledSelect();

        return $subquery;
    }

    public function index()
    {   
        $subquery = $this->getLatestUpdatedSubquery();

        $builder = $this->db
            ->table('statustempatsampah sts')
            ->select([
                'ts.ID',
                'ts.Latitude',
                'ts.Longitude',
                'sts.WaktuAmbil',
                'js.Deskripsi'])
            ->join("($subquery) sts2", 'sts2.LastWaktuAmbil = sts.WaktuAmbil')
            ->join('tempatsampah ts', 'ts.ID = sts.TempatSampah_ID')
            ->join('jenisstatus js', 'js.ID = sts.JenisStatus_ID');
        
        $data['bins'] = $builder->get()->getResultArray();
        
        return view('home', $data);
    }

    public function getData()
    {
        $sensor_data = $this->request->getBody();
        $builder = $this->db->table('statustempatsampah');
        $builder->insert(json_decode($sensor_data));
        dd($sensor_data);
    }
}
