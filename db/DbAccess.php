<?php

namespace Db;

use MongoDB\Client;

class DbAccess
{
    /**
     * @var Client $db
     */

    private $db;
    static $fosrmStart = "<form method='post' action=''>";
    static $formEnd = "</form>";

    public function __construct()
    {
        SingletonDbInit::initiateDb();
        $this->db = SingletonDbInit::getDb();
    }

    public function chooseRequest(array $post)
    {
        if (isset($post["bookByPublisher"])) {
            $this->findBookByPublisher($post["Publisher"]);
        } elseif (isset($post["literatureByDate"])) {
            $this->findLiteratureByDate($post["dateStart"], $post["dateEnd"]);
        } elseif (isset($post["bookByAuthor"])) {
            $this->findBookByAuthor($post["Author"]);
        }
    }

    private function findBookByPublisher(string $publisher)
    {
        $statement = $this->db->find(["literate"=>"Book", "Publisher"=>"$publisher"]);

        echo "<table style='text-align: center'>";
        $str = "";
        echo "<tr><th>Title</th><th>ISBN</th><th>Publisher</th><th>Year</th><th>Number Of Pages</th></tr>";
        foreach ($statement->toArray() as $value) {
            $str.= "Title {$value['title']} -- ISBN {$value['ISBN']} -- Publisher {$value['Publisher']}<br>";
            echo "
                <tr>
                    <td>{$value['title']}</td>
                    <td>{$value['ISBN']}</td>
                    <td>{$value['Publisher']}</td>
                    <td>{$value['Date']}</td>
                    <td>{$value['Quantity']}</td>
                </tr>
            ";
        }
        setcookie("savedData", $str);
    }

    private function findLiteratureByDate(mixed $dateStart, mixed $dateEnd)
    {
        $dateStart = (new \DateTime($dateStart))->getTimestamp();
        $dateEnd = (new \DateTime($dateEnd))->getTimestamp();
        $statement = $this->db->find([]);
        $str = "";

        echo "<table style='text-align: center'>";
        echo "<tr><th>Name</th><th>Date</th><th>Literate</th>";
        foreach ($statement->toArray() as $data){
            if(intval($data["Date"]."")/1000>$dateStart && intval($data["Date"]."")/1000<$dateEnd){
                $date = floor(intval($data["Date"]."")/31688764600+1970);
                $str.= "Title {$data['title']} -- Year $date -- Publisher {$data['literate']}<br>";
                echo "
                <tr>
                    <td>{$data['title']}</td>
                    <td>{$date}</td>
                    <td>{$data['literate']}</td>
                </tr>
            ";
            }
        }
        setcookie("savedData", $str);
    }

    private function findBookByAuthor(string $author)
    {
        $statement = $this->db->find(["literate"=>"Book", "Author"=>"$author"]);
        $str = "";

        echo "<table style='text-align: center'>";
        echo "<tr><th>Title</th><th>ISBN</th><th>Publisher</th><th>Year</th><th>Number Of Pages</th><th>Author</th></th></tr>";
        foreach ($statement->toArray() as $value) {
            $str.= "Title {$value['title']} -- ISBN {$value['ISBN']} -- Publisher {$value['Publisher']} -- Author {$value['Author']}<br>";
            echo "
                <tr>
                    <td>{$value['title']}</td>
                    <td>{$value['ISBN']}</td>
                    <td>{$value['Publisher']}</td>
                    <td>{$value['Date']}</td>
                    <td>{$value['Quantity']}</td>
                    <td>{$value['Author']}</td>
                </tr>
            ";
        }
        setcookie("savedData", $str);
    }

    public function viewSelect(string $name)
    {
        $statement = $this->db->distinct($name, ["literate"=>"Book"]);

        echo "<select name='$name'>";
        foreach ($statement as $value) {
            echo "<option value='$value'>$value</option>";
        }
        echo "</select>";

        if ($name === "Publisher") {
            echo "<input type='submit' name='bookByPublisher' value='Find Book'>";
            echo "<input type='button' name='bookByPublisher' value='Show Saved Request' onclick='lookForBookByPublisher()'>";
        } elseif ($name === "Author") {
            echo "<input type='submit' name='bookByAuthor' value='Find Book'>";
        }
    }

    public function viewDate()
    {
        echo "<label>From Date: <input type='date' name='dateStart'></label>";
        echo "<label> To Date: <input type='date' name='dateEnd'></label>";
        echo "<input type='submit' name='literatureByDate' value='Find Literature'>";
    }
}