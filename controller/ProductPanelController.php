<?php

require_once("model/Izdelek_B.php");
require_once("ViewHelper.php");
require_once("forms/IzdelekForm.php");

class ProductPanelController
{

    public static function panel()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:" . BASE_URL . "login");
            exit;
        }
        if ($_SESSION["vloga_id"] == 3) {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            echo "401 Unauthorized";
            exit;
        }
        $izdelki = Izdelek_B::getAll();
        foreach ($izdelki as $key => $izdelek) {
            $izdelki[$key]["slike"] = Slika_B::get(["izdelek_id" => $izdelek["idIzdelek"]]);
        }
        echo ViewHelper::render("view/productpanel.php", [
            "izdelki" => $izdelki
        ]);

    }

    public static function add()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:" . BASE_URL . "login");
            exit;
        }
        if ($_SESSION["vloga_id"] == 3) {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            echo "401 Unauthorized";
            exit;
        }
        $form = new IzdelekInsertForm("add_form");

        if ($form->isSubmitted() && $form->validate()) {
            $id = Izdelek_B::insert(array_merge(
                $form->getValue(), ["aktiven" => 1]
            ));

            Log_B::insert(
                ["idUporabnik" => $_SESSION["idUporabnik"], "komentar" => "Dodan nov izdelek z id-jem: " . $id]
            );



            ViewHelper::redirect(BASE_URL . "store");
        } else {
            echo ViewHelper::render("view/izdelek-form.php", [
                "form" => $form,
                "title" => "Dodaj izdelek"
            ]);
        }
    }

    public static function edit()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:" . BASE_URL . "login");
            exit;
        }
        if ($_SESSION["vloga_id"] == 3) {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            echo "401 Unauthorized";
            exit;
        }
        $editForm = new IzdelekEditForm("edit_form");
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $GET_data = filter_input_array(INPUT_GET, $rules);

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $data = $editForm->getValue();
                $data["idIzdelek"] = $GET_data["id"];
                if (!isset($data["aktiven"]))
                    $data["aktiven"] = 0;
                Izdelek_B::update($data);

                Log_B::insert(
                    ["idUporabnik" => $_SESSION["idUporabnik"], "komentar" => "Posodobljen izdelek z id-jem: " . $data["idIzdelek"]]
                );


                ViewHelper::redirect(BASE_URL . "productpanel");
            } else {
                echo ViewHelper::render("view/izdelek-form.php", [
                    "title" => "Urejanje izdelka",
                    "form" => $editForm,
                ]);
            }
        } else {

            if ($GET_data["id"]) {
                $izdelek = Izdelek_B::get($GET_data);
                $dataSource = new HTML_QuickForm2_DataSource_Array($izdelek);
                $editForm->addDataSource($dataSource);

                echo ViewHelper::render("view/izdelek-form.php", [
                    "title" => "Urejanje izdelka",
                    "form" => $editForm,
                ]);
            } else {
                throw new InvalidArgumentException("editing nonexistent entry");
            }
        }
    }


}
