<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use IonAuth\Libraries\IonAuth;
use PharIo\Manifest\Library;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		session();
		helper('form'); 
		setlocale(LC_TIME, 'Indonesian');
		$this->db = \Config\Database::connect();
		$this->auth = new \IonAuth\Libraries\IonAuth();  
		$this->user = $this->auth->getProfile();
		$this->session = \Config\Services::session();
		$this->group_name = $this->auth->getUsersGroups()->getRow()->name;
		$this->pelanggaranModel = new \App\Models\PelanggaranModel();
		$this->KpelanggaranModel = new \App\Models\KPelanggaranModel();
		$this->JpelanggaranModel = new \App\Models\JPelanggaranModel();
		$this->lokasiModel = new \App\Models\LokasiModel();
		$this->sanksiModel = new \App\Models\SanksiModel();
		$this->jadwalModel = new \App\Models\JadwalModel();
		$this->komdismaModel = new \App\Models\KomdismaModel();
		$this->akademikModel =  new \App\Models\AkademikModel();
		$this->dosenModel = new \App\Models\DosenModel();
		$this->mahasiswaModel = new \App\Models\MahasiswaModel();
		$this->laporModel = new \App\Models\LaporModel();
		$this->penundaanModel = new \App\Models\PenundaanSkorsModel();
		$this->suratModel = new \App\Models\SuratKelakuanModel();
		$this->jumlahVerifikasi = $this->pelanggaranModel->countVerifikasi();
		$this->jumlahLapor = $this->laporModel->countLapor();
		$this->jumlahPengajuan = $this->penundaanModel->countPengajuan();
		$this->jumlahPengajuanSurat = $this->suratModel->countPengajuan();

     
	}
	
}
