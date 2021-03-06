<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class ap extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/apNavbar';
        $this->load->model('inventaris_model');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //halaman tambah unit
    public function index() {
        redirect(base_url().'hClinic/'.$this->uri->segment(2, 0).'/updatePuskesmas');
        $data['allPuskesmas'] = $this->inventaris_model->getAllEntry_byGedung();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('pInsert',$data);
    }
    
    function createPuskesmas()
    {
        $this->title="";
        $this->display('pInsert');
        $this->left_sidebar = 'lay-left-sidebar/hClinic_sidebar';
    }

    function addPuskesmas()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'noid_gedung' => $form_data['inputNoidGedung'],
                'nama_gedung' => $form_data['inputNamaGedung'],
                'jalan_gedung' => $form_data['inputJalan'],
                'kelurahan_gedung' => $form_data['inputKelurahan'],
                'kecamatan_gedung' => $form_data['inputKecamatan'],
                'kabupaten_gedung' => $form_data['inputKabupaten'],
                'provinsi_gedung' => $form_data['inputProvinsi']
            );  
            if($this->pPuskesmas->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/hClinic', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updatePuskesmas()
    {
        $this->title="";
        $data['selectedPuskesmas'] = $this->pPuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        
        if ($data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $this->display('pUpdateHClinicOwner', $data);
        }
        
    }
    
    function saveUpdatePuskesmas()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'noid_gedung' => $form_data['inputNoidGedung'],
                'nama_gedung' => $form_data['inputNamaGedung'],
                'jalan_gedung' => $form_data['inputJalan'],
                'kelurahan_gedung' => $form_data['inputKelurahan'],
                'kecamatan_gedung' => $form_data['inputKecamatan'],
                'kabupaten_gedung' => $form_data['inputKabupaten'],
                'provinsi_gedung' => $form_data['inputProvinsi']
            );
        }
        $this->pPuskesmas->updateEntry($form_data['selectedIdGedung'], $data); 
        redirect( base_url().'hClinic/'.$this->uri->segment(2, 0).'/updatePuskesmas', 'refresh');   
    }
    
    function removePuskesmas()
    {
        $form_data = $this->input->post(null, true);
        if(!is_null($form_data['selected']))
        {
            $this->pPuskesmas->deleteById ($form_data['selected']);
            redirect( base_url().'index.php/hClinic', 'refresh');
        }
    }
}