<?php

class mysql {

    var $db;
    var $sth;

    function __construct($db) {
        $this->db = $db;
    }

    function validate_login($email, $password, $logintype) {
        $this->sth = $this->db->prepare("SELECT * FROM customer WHERE email = :EMAIL and password = :PASSWORD and logintype = :LOGINTYPE");
        $this->sth->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $this->sth->bindValue(":PASSWORD", $password, PDO::PARAM_STR);
        $this->sth->bindValue(":LOGINTYPE", $logintype, PDO::PARAM_INT);
        $this->sth->execute();
        return $this->sth->fetchAll();
    }

    function add_user($user_details) {
        $this->sth = $this->db->prepare("insert into customer(email, password, cname, phone_no, logintype) values(:EMAIL, :PASSWORD, :CNAME, :PHONE, :LOGINTYPE)");
//        echo 'insert into customer(email, password, cname, phone_no, logintype) values("' . $user_details["email"] . '", "' . $user_details["password"] . '", "' . $user_details["cname"] . '", "' . $user_details["phone"] . '", ' . $user_details["logintype"] . ')';
//        die;
        $this->sth->bindValue(':EMAIL', $user_details['email'], PDO::PARAM_STR);
        $this->sth->bindValue(':PASSWORD', $user_details['password'], PDO::PARAM_STR);
        $this->sth->bindValue(':CNAME', $user_details['cname'], PDO::PARAM_STR);
        $this->sth->bindValue(':PHONE', $user_details['phone'], PDO::PARAM_STR);
        $this->sth->bindValue(':LOGINTYPE', $user_details['logintype'], PDO::PARAM_INT);

        $this->sth->execute();
        return $this->db->lastInsertId();
    }

    function update_session_id($user_id, $session_id) {
        $this->sth = $this->db->prepare("UPDATE customer SET session_id=:SESSION_ID WHERE cid =:CID");
        $this->sth->bindValue(':SESSION_ID', $session_id, PDO::PARAM_STR);
        $this->sth->bindValue(':CID', $user_id, PDO::PARAM_STR);
        return $this->sth->execute();
    }

    function get_user_by_email($user_email) {
        $this->sth = $this->db->prepare("SELECT * FROM customer WHERE email = :EMAIL");
        $this->sth->bindValue(":EMAIL", $user_email, PDO::PARAM_STR);
        $this->sth->execute();
        return $this->sth->fetchAll();
    }

    function nullify_sessionid($cid) {
//        echo "UPDATE customer SET session_id= null WHERE cid = $cid";die;
        $this->sth = $this->db->prepare("UPDATE customer SET session_id= null WHERE cid = $cid");
        $this->sth->execute();
        sleep(1);
    }

    function add_owner($owner_details) {
        $this->sth = $this->db->prepare("insert into owner(owner_name, email, owner_type) values(:OWNER_NAME, :EMAIL, :OWNER_TYPE)");
        $this->sth->bindValue(':OWNER_NAME', $owner_details['full_name'], PDO::PARAM_STR);
        $this->sth->bindValue(':EMAIL', $owner_details['email'], PDO::PARAM_STR);
        $this->sth->bindValue(':OWNER_TYPE', $owner_details['owner_type'], PDO::PARAM_INT);

        $this->sth->execute();
        return $this->db->lastInsertId();
    }

    function get_owner_by_email($email) {
        $this->sth = $this->db->prepare("SELECT * FROM owner WHERE email = :EMAIL");
        $this->sth->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $this->sth->execute();
        return $this->sth->fetchAll();
    }

    function get_all_owners() {
        $this->sth = $this->db->prepare("SELECT * FROM owner");
        $this->sth->execute();
        return $this->sth->fetchAll();
    }

    function get_all_cars() {
        $this->sth = $this->db->prepare("SELECT * FROM car");
        $this->sth->execute();
        return $this->sth->fetchAll();
    }

    function get_owner_name_by_oid($oid) {
        $this->sth = $this->db->prepare("SELECT * FROM owner WHERE oid = :OWNER");
        $this->sth->bindValue(":OWNER", $oid, PDO::PARAM_INT);
        $this->sth->execute();
        return $this->sth->fetchAll();
    }

    function add_car($car_details) {

//        echo "insert into car(model, cyear, daily_rate, weekly_rate, oid, lease_date) values('" . $car_details['car_model'] . "', '" . $car_details['year'] . "', '" . $car_details['daily_rate'] . "', '" . $car_details['weekly_rate'] . "', '" . $car_details['owner_id'] . "', '" . $car_details['lease_date'] . "')";
//        die;
        if ($car_details['lease_date'] == '' || empty($car_details['lease_date'])) {
            $this->sth = $this->db->prepare("insert into car(model, cyear, daily_rate, weekly_rate, oid, lease_date) values('" . $car_details['car_model'] . "', '" . $car_details['year'] . "', '" . $car_details['daily_rate'] . "', '" . $car_details['weekly_rate'] . "', '" . $car_details['owner_id'] . "', null)");
        } else {
            $this->sth = $this->db->prepare("insert into car(model, cyear, daily_rate, weekly_rate, oid, lease_date) values('" . $car_details['car_model'] . "', '" . $car_details['year'] . "', '" . $car_details['daily_rate'] . "', '" . $car_details['weekly_rate'] . "', '" . $car_details['owner_id'] . "', '" . $car_details['lease_date'] . "')");
        }
//        $this->sth->bindValue(':MODEL', $car_details['car_model'], PDO::PARAM_STR);
//        $this->sth->bindValue(':CYEAR', $car_details['year'], PDO::PARAM_STR);
//        $this->sth->bindValue(':DAILY_RATE', $car_details['daily_rate'], PDO::PARAM_INT);
//        $this->sth->bindValue(':WEEKLY_RATE', $car_details['weekly_rate'], PDO::PARAM_INT);
//        $this->sth->bindValue(':OID', $car_details['owner_id'], PDO::PARAM_INT);
//        $this->sth->bindValue(':LEASE_DATE', $car_details['lease_date'], PDO::PARAM_STR);

        $this->sth->execute();
        return $this->db->lastInsertId();
    }

}
