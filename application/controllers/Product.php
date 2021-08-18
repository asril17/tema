<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    private $count;

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('login')) {
            redirect('Auth');
        }
        $this->load->model('Master_model', 'master');

        $this->count = $this->master->getCountTrans();
    }
    public function prepaidBalance()
    {
        $data['count'] = $this->count;
        $this->load->view('Template/Header');
        $this->load->view('Product/PrepaidBalance', $data);
        $this->load->view('Template/Footer');
    }

    public function insertPrepaidBalance()
    {
        $p = $this->input->post();
        date_default_timezone_set('Asia/jakarta');


        $order_no = $this->master->getOrderNo();
        $total = $p['value'] + ($p['value'] * 0.05);
        $data = [
            'id_member' => $this->session->userdata('id'),
            'transaction_type' => 'Prepaid Balance',
            'order_no' => $order_no,
            'mobile_number' => $p['mobileNumber'],
            'value' => $p['value'],
            'product' => NULL,
            'shipping_address' => NULL,
            'price' => NULL,
            'status' => 'Created',
            'created_date' => date('Y-m-d H:i:s'),
            'total' => $total
        ];

        $insertPrepaid = $this->master->insertTransaction($data);

        if ($insertPrepaid) {
            $trans = $this->master->getIdTransaction('Prepaid Balance');
            redirect('Product/success/' . $trans['id_transaction']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Created order failed</div> ');
            redirect('Product/prepaidBalance');
        }
    }
    public function productPage()
    {
        $data['count'] = $this->count;

        $this->load->view('Template/Header');
        $this->load->view('Product/ProductPage', $data);
        $this->load->view('Template/Footer');
    }

    public function insertProduct()
    {

        $p = $this->input->post();
        // dd($p);
        // die;
        date_default_timezone_set('Asia/jakarta');
        $order_no = $this->master->getOrderNo();
        $total = $p['price'] + 10000;

        $data = [
            'id_member' => $this->session->userdata('id'),
            'transaction_type' => 'Product Page',
            'order_no' => $order_no,
            'mobile_number' => NULL,
            'value' => NULL,
            'product' => $p['namaProduct'],
            'shipping_address' => $p['shippingAddress'],
            'price' => $p['price'],
            'status' => 'Created',
            'created_date' => date('Y-m-d H:i:s'),
            'total' => $total
        ];

        $insertPrepaid = $this->master->insertTransaction($data);
        if ($insertPrepaid) {
            $trans = $this->master->getIdTransaction('Product Page');
            redirect('Product/success/' . $trans['id_transaction']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Created order failed</div> ');
            redirect('Product/productPage');
        }
    }
    public function success($id_transaction)
    {

        $getTransaction = $this->master->getTransactionById($id_transaction);

        $data['detail'] = $getTransaction;
        $data['count'] = $this->count;
        $this->load->view('Template/Header');
        $this->load->view('Product/Success', $data);
        $this->load->view('Template/Footer');
    }
    public function payOrder($id_transaction)
    {
        $getTransaction = $this->master->getTransactionById($id_transaction);
        $data['data'] = $getTransaction;
        $data['count'] = $this->count;
        $this->load->view('Template/Header');
        $this->load->view('Product/PayOrder', $data);
        $this->load->view('Template/Footer');
    }

    public function updatePayOrder()
    {
        $id_transaction = $this->input->post('id_transaction');
        $order_no = $this->input->post('order_no');

        $trans = $this->master->getTransactionById($id_transaction);

        date_default_timezone_set('Asia/jakarta');

        $created_date = strtotime($trans['created_date']);
        $now_date = strtotime(date('Y-m-d H:i:s'));

        $minute = round(abs($now_date - $created_date) / 60);
        // dd($trans['created_date']);
        // dd(date('Y-m-d H:i:s'));
        // dd($minute);
        // die;

        if ($order_no == $trans['order_no']) {


            if ($trans['transaction_type'] == 'Prepaid Balance') {


                $date = date('H');

                $random = rand(1, 10);

                if ($date >= '09' && $date <= '17') {

                    $status = $random <= 9 ? 'Success' : 'Failed';
                } else {
                    $status = $random <= 4 ? 'Success' : 'Failed';
                }

                if ($minute > 5) {
                    $status = 'Canceled';
                }

                $data = [
                    'status' => $status,
                    'transaction_date' => date('Y-m-d H:i:s'),
                ];
            } else {
                if ($minute > 5) {
                    $status = 'Canceled';
                    $data = [
                        'status' => $status,
                        'shipping_code' => NULL,
                        'transaction_date' => date('Y-m-d H:i:s'),
                    ];
                } else {
                    $data = [
                        'status' => 'Success',
                        'shipping_code' => $this->master->alphaNumeric(8),
                        'transaction_date' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            $this->master->updateTransaction($data, $id_transaction);
        }

        redirect('Product/orderHistory');
    }


    public function orderHistory()
    {
        $this->updateStatus();
        $this->load->library('pagination');

        $config['base_url'] = base_url() . "/Product/orderHistory";
        $config['total_rows'] = $this->master->countTransaction();
        $config['per_page'] = 4;

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $data['start'] = $this->uri->segment(3);
        $transaction = $this->master->getTransactionLimit($config['per_page'], $data['start']);

        $data['transaction'] = $transaction;
        $data['count'] = $this->count;
        $this->load->view('Template/Header');
        $this->load->view('Product/OrderHistory', $data);
        $this->load->view('Template/Footer');
    }

    public function search()
    {
        $this->load->library('pagination');
        $keyword = $this->input->post('keyword');

        if ($keyword != '') {
            $data['keyword'] = $keyword;
            $this->session->set_userdata($data);
            $this->db->like('order_no', $data['keyword']);
            // $this->db->where("'order_no LIKE '%$keyword%'");
            $this->db->where('id_member', $this->session->userdata('id'));
            $this->db->from('transaction');
            $config['total_rows'] = $this->db->count_all_results();
        } else {
            $data['keyword'] = null;
            $config['total_rows'] = $this->master->countTransaction();
        }

        $config['base_url'] = "#";
        $config['per_page'] = 4;

        $config['attributes'] = array('class' => 'page-link pagi', 'data-link' => base_url() . '/Product/searchPagination');

        $this->pagination->initialize($config);
        $data['start'] = $this->uri->segment(3);
        $transaction = $this->master->getTransactionLimit($config['per_page'], $data['start'], $data['keyword']);

        $data['transaction'] = $transaction;
        $data['pagination'] = $this->pagination->create_links();

        echo json_encode($data);
    }

    public function searchPagination($start = '')
    {
        // if ($keyword != '') {
        //     $data['keyword'] = $keyword;
        // } else {
        //     $data['keyword'] = null;
        // }
        $data['keyword'] = $this->session->userdata('keyword');

        // dd($this->session->userdata());
        // die;

        $this->load->library('pagination');
        $this->db->like('order_no', $data['keyword']);
        $this->db->from('transaction');
        // $config['total_rows'] = $this->master->countTransaction();
        $config['base_url'] = "#";
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 4;

        $config['attributes'] = array('class' => 'page-link pagi', 'data-link' => base_url() . '/Product/searchPagination');

        $this->pagination->initialize($config);
        $data['start'] = $start;
        $transaction = $this->master->getTransactionLimit($config['per_page'], $data['start'], $data['keyword']);

        $data['transaction'] = $transaction;
        $data['pagination'] = $this->pagination->create_links();

        echo json_encode($data);
    }

    public function updateStatus()
    {

        date_default_timezone_set('Asia/jakarta');
        $trans = $this->master->getTransaction();

        foreach ($trans as $row) {
            $created_date = strtotime($row['created_date']);
            $now_date = strtotime(date('Y-m-d H:i:s'));

            $minute = round(abs($now_date - $created_date) / 60);


            if ($row['transaction_type'] == 'Prepaid Balance') {
                if ($minute > 5) {
                    $status = 'Canceled';
                }

                $data = [
                    'status' => $status,
                    'transaction_date' => date('Y-m-d H:i:s'),
                ];
                $this->master->updateTransaction($data, $row['id_transaction']);
            } else {

                if ($minute > 5) {
                    $status = 'Canceled';
                    $data = [
                        'status' => $status,
                        // 'shipping_code' => NULL,
                        'transaction_date' => date('Y-m-d H:i:s'),
                    ];
                    $this->master->updateTransaction($data, $row['id_transaction']);
                }
                // else {
                //     $data = [
                //         'shipping_code' => $this->master->alphaNumeric(8),
                //         'transaction_date' => date('Y-m-d H:i:s'),
                //     ];
                // }
            }
        }

        return true;
    }
}
