<?php
use PHPUnit\Framework\TestCase;
use App\Catalog;

class CatalogTest extends TestCase{
    private $katalog;
    private $testFile = __DIR__ . '/test_products.json';

    protected function setUp(): void{
        $dummyData = ["PRD-1" => ["nama" => "Kemeja Flanel", "harga" => 150000, "stok" => 10]];
        file_put_contents($this->testFile, json_encode($dummyData));
        $this->katalog = new Catalog($this->testFile);
    }

    // UT-01: Keyword valid, produk ditemukan
    public function testSearchProductFound(){
        $result = $this->katalog->searchProduct("Kemeja");
        $this->assertCount(1, $result);
    }

    // UT-02: Keyword kosong, kembalikan semua produk
    public function testSearchAllProductsWhenKeywordEmpty(){
        $result = $this->katalog->searchProduct("");
        $this->assertNotEmpty($result);
    }

    // UT-03: Keyword tidak cocok, kembalikan array kosong
    public function testSearchProductNotFound(){
        $result = $this->katalog->searchProduct("xxxxx");
        $this->assertEmpty($result);
    }

    // UT-04: Keyword huruf kecil, tetap ditemukan (case-insensitive)
    public function testSearchProductCaseInsensitive(){
        $result = $this->katalog->searchProduct("kemeja");
        $this->assertCount(1, $result);
    }

    protected function tearDown(): void{ unlink($this->testFile); }
}