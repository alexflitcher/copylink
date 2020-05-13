<?php
namespace LinkDir\Classes;
class MakeDir {
    public $hash, $host;
    private $link, $newlink;
    public function __construct($link, $host) {
      $this->link = $link;
      $this->host = $host;
    }

    public function generateHashLink() {
      $this->hash = md5($this->link);
    }

    public function makePageLink() {
      $this->newlink = $this->host . $this->hash . ".php";
      $f = fopen($this->hash . ".php", 'w') or die("Ошибка создания");
      $text = "<script>window.location='$this->link'</script>";
      fwrite($f, $text) or die("Ошибка записи");
      fclose($f);
      return $this->newlink;
    }
  }
?>
