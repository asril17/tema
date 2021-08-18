<?php

class Master_model extends CI_Model
{

    function insertMember($data)
    {
        $this->db->insert('member', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    function insertTransaction($data)
    {
        $this->db->insert('transaction', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    function getTransaction()
    {
        return $this->db->where('status', 'Created')->get('transaction')->result_array();
    }

    function updateTransaction($data, $id_transaction)
    {
        $this->db->where('id_transaction', $id_transaction);
        $this->db->update('transaction', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getIdTransaction($tipe)
    {

        $query = $this->db->select('id_transaction')
            ->where('transaction_type', $tipe)
            ->where('id_member', $this->session->userdata('id'))
            ->limit(1)
            ->order_by('id_transaction', 'DESC')
            ->get('transaction')->row_array();

        return $query;
    }

    function getTransactionById($id_transaction)
    {
        $query = $this->db->where('id_transaction', $id_transaction)
            ->get('transaction')->row_array();

        return $query;
    }

    function getTransactionLimit($limit, $start, $keyword = null)
    {
        if ($keyword) {
            // $this->db->where("'order_no LIKE '%$keyword%'");
            $this->db->like('order_no', $keyword);
        }
        $this->db->where('id_member', $this->session->userdata('id'));
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('transaction', $limit, $start)->result_array();
    }

    function countTransaction()
    {
        return $this->db->where('id_member', $this->session->userdata('id'))->get('transaction')->num_rows();
    }

    function getCountTrans()
    {
        $query = $this->db->where('id_member', $this->session->userdata('id'))
            ->where('status', 'Created')
            ->get('transaction')->num_rows();

        return $query;
    }

    function getOrderNo()
    {
        $x = rand(1000000000, 9999999999);
        $get_no_transaksi = $this->db->query("select max(right(order_no,3)) as max_id from transaction");
        $kd = "";
        if ($get_no_transaksi->num_fields() > 0) {
            foreach ($get_no_transaksi->result() as $k) {
                $tmp = ((int)$k->max_id) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        $no = $x . $kd;
        return $no;
    }

    function alphaNumeric($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
