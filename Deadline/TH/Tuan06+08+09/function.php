<?php

function createUser($id, $name, $address, $phone, $gender, $email, $birth){
    global $db;
    $stmt = $db->prepare("INSERT INTO users (id, name, address, phone, gender, email, birth) VALUE (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($id, $name, $address, $phone, $gender, $email, $birth));
    return $db->lastInsertId();
}

function findUserById($id){
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function getAllUsers() {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function getAllSubjects() {
    global $db;
    $stmt = $db->prepare("SELECT * FROM subjects");
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $subjects;
}

function registrationSubjects($user_id, $subject_id){
    global $db;
    $stmt = $db->prepare("INSERT INTO registration (user_id, subject_id) VALUE (?, ?)");
    $stmt->execute(array($user_id, $subject_id));
    return $db->lastInsertId();
}

function getRegistrationSubjectsById($id){
    global $db;
    $stmt = $db->prepare("SELECT * FROM registration as r LEFT JOIN subjects as s ON r.subject_id = s.id WHERE user_id = $id");
    $stmt->execute();
    $register = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $register;
}

?>