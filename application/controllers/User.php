<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();//manggil parent construct yang ada di CI
        $this->load->library('form_validation'); //agar librari validasi form bsa dgunakan dimana aja
    }
    public function index()
    {
        $data['title'] = 'Dashboard Applicant';
        $data['user'] = $this->db->get_where('user', ['username'=> $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar-user',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('user/index',$data);//ngirim variable user data ke page User nanti 
        $this->load->view('templates/footer');
    }
    public function profile()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['username'=> $this->session->userdata('username')])->row_array();
        $lol = $this->session->userdata('username');
        $result= $this->db->query("SELECT `user_id` FROM `user` WHERE `username` = '$lol'")->row()->user_id;
        $query = $this->db->query("SELECT * FROM `applicant` WHERE `user_id` = $result");
        $row = $query->row_array();
        $data['applicant']= $row;
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar-user',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('user/profile',$data);//ngirim variable user data ke page User nanti 
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['username'=> $this->session->userdata('username')])->row_array();
        // $data['applicant'] = $this->db->get_where('applicant', ['email'=> $this->session->userdata('email')])->row_array();
        $lol = $this->session->userdata('username');
        $result= $this->db->query("SELECT `user_id` FROM `user` WHERE `username` = '$lol'")->row()->user_id;
        $query = $this->db->query("SELECT * FROM `applicant` WHERE `user_id` = $result");
        $row = $query->row_array();
        $data['applicant']= $row;
        $this->form_validation->set_rules('name','Full Name', 'required|trim');
        $this->form_validation->set_rules('monthlyIncome','monthlyIncome','required|numeric'); 
        if($this->form_validation->run()==false)
        {
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar-user',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('user/edit',$data);//ngirim variable user data ke page User nanti 
            $this->load->view('templates/footer');
        }
        else
        {
            //ambil data inputan user di web form
            $name = $this->input->post('name');
            $email = $this->input->post('email');   
            $monthlyIncome = $this->input->post('monthlyIncome');
            $upload_image = $_FILES['image']['name'];

            if($upload_image)
            {
                $config['upload_path'] = './assets/img';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);//load librari upload
            
                if($this->upload->do_upload('image'))
                {
                    //menghapus image lama biar ga menuh" in kecuali default profile image
                    $old_image = $data['user']['image'];
                    if($old_image != 'default.jpg')
                    {
                        unlink(FCPATH . 'assets/img/'. $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                }
                else
                {
                    echo $this->upload->dispay_errors();
                }

            }
            
            $this->db->set('name', $name);//update isi database 
            $this->db->where('user_id',$result);//kondisi dimana id nya harus sama dengan yg login sama yang ada di dataabse
            $this->db->update('user');//update di tablenya user
            $this->db->set('monthlyIncome', $monthlyIncome);//update isi database
            $this->db->where('email', $email);//kondisi dimana username/emailnya harus cocok dengan yang di database
            $this->db->update('applicant');//update di tablenya user
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">Your profile has been updated! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('user/profile');
        }
    }
    public function view_residences()
    {
        $data['title'] = 'View Residences';
        $data['user'] = $this->db->get_where('user', ['username'=> $this->session->userdata('username')])->row_array();
        $data['residences'] = $this->db->get('residences')->result_array();
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar-user',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('user/view_residences',$data);//ngirim variable user data ke page User nanti 
        $this->load->view('templates/footer');
    }

}
