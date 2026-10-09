<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST");

require "config.php";

$rota = $_GET["rota"] ?? "teste";

function listarAlunos($con) {
    $stmt = $con->query("SELECT * FROM alunos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function listarInstrutores($con) {
    $stmt = $con->query("SELECT * FROM instrutores");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function listarAulas($con) {
    $stmt = $con->query("SELECT * FROM aulas");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function adicionaraluno($con) {
    $aluno = $_POST["aluno"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_nascimento = $_POST["data_nascimento"];

    try {
        $stmt = $con->prepare(
            "INSERT INTO alunos (nome, email, telefone, data_nascimento)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->execute([
            $aluno,
            $email,
            $telefone,
            $data_nascimento
        ]);

        header("Location: ../front/index.html");

    } catch (PDOException $e) {
        header("Location: ../front/erro.html");
    }

    exit;
}

switch ($rota) {

    case "alunos":
        listarAlunos($con);
        break;

    case "instrutores":
        listarInstrutores($con);
        break;

    case "aulas":
        listarAulas($con);
        break;

    case "adicionaraluno":
        adicionaraluno($con);
        break;
}