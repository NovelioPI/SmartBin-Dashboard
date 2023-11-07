<?php

namespace App\Controllers;

use Exception;

class Home extends BaseController
{
    function __construct()
    {
        $this->db = db_connect();
    }

    private function getLatestDataQuery() 
    {
        $subquery = $this->db
            ->table('statustempatsampah')
            ->select([
              'TempatSampah_ID',
              'max(WaktuAmbil) as LastWaktuAmbil'
              ])
            ->groupBy('TempatSampah_ID')
            ->getCompiledSelect();

        $query = $this->db
            ->table('statustempatsampah sts')
            ->select([
                'ts.ID',
                'ts.Latitude',
                'ts.Longitude',
                'sts.WaktuAmbil',
                'js.Deskripsi'])
            ->join("($subquery) sts2", 'sts2.TempatSampah_ID = sts.TempatSampah_ID and sts2.LastWaktuAmbil = sts.WaktuAmbil')
            ->join('tempatsampah ts', 'ts.ID = sts.TempatSampah_ID')
            ->join('jenisstatus js', 'js.ID = sts.JenisStatus_ID');
        
        return $query;
    }

    public function index()
    {   
        return view('home');
    }

    public function settings()
    {
        $query = $this->db
            ->table('tempatsampah ts')
            ->get()
            ->getResultArray();
        
        $data['bins'] = $query;
        
        return view('settings', $data);
    }

    public function edit($id)
    {
        $query = $this->db
            ->table('tempatsampah ts')
            ->where('ID', $id)
            ->get()
            ->getRowArray();

        $data['bin'] = $query;

        return view('edit', $data);
    }

    public function editBin($id)
    {
        $post = $this->request->getPost();
        
        if (!$this->validate([
          'Latitude' => 'required',
          'Longitude' => 'required'
        ])) {
            return redirect()->back();
        }

        $bin = [
            'Latitude' => (float) $post['Latitude'],
            'Longitude' => $post['Longitude']
        ];

        $this->db->transBegin();
        $status = $this->db->table('tempatsampah ts')
            ->update($bin, ['id' => $id]);

        if ($status) {
            $this->db->transCommit();
            return redirect()->to('/settings');
        }

        $this->db->transRollBack();
        return redirect()->to('/settings');
    }

    public function getLatestBinsData()
    {
        try {
            $builder = $this->getLatestDataQuery();
            $bins = $builder->get()->getResultArray();
    
            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status'    => '1',
                    'messages'  => null,
                    'errors'    => null,
                    'data'      => $bins
            ]);
            
        } catch (Exception $e) {
            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'    => '0',
                    'messages'  => null,
                    'errors'    => $e->getMessage(),
                    'data'      => null
            ]);
        }
    }

    public function setBinData()
    {
        $requestBody = $this->request->getBody();

        try {
            $builder = $this->db
                ->table('statustempatsampah sts')
                ->insert(json_decode($requestBody));

            if ($builder) {
                return $this->response
                    ->setJSON([
                        'status'    => '1',
                        'message'   => null,
                        'errors'    => null,
                        'data'      => $builder
                    ]);
            }

        } catch (Exception $e) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'    => '0',
                    'messages'  => null,
                    'errors'    => $e->getMessage(),
                    'data'      => null
            ]);
        }
    }
}
