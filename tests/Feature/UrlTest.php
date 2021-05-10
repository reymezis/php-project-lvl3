<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->seed();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testShow()
    {
        $id = $this->faker->numberBetween(1, 4);
        $url = DB::table('urls')->find($id)->name;
        $responce = $this->get(route('urls.show', $id));
        $responce->assertOk();
        $responce->assertSee($url);
    }

    public function urlsProvider()
    {
        return [
            ['http://test.com'],
            ['https://google.ru'],
            ['http://twitter.com']
        ];
    }

    public function invalidUrlsProvider()
    {
        return [
            ['test'],
            [''],
            ['https:cool.com'],
            ['site.com']
        ];
    }

    /**
     * @dataProvider urlsProvider
     */
    public function testStore($url)
    {
        $data = ['name' => $url];
        $response = $this->post(route('urls.store'), ['url' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('urls', $data);
    }

    /**
     * @dataProvider invalidUrlsProvider
     */
    public function testStoreInvalidUrl($invalidUrl)
    {
        $data = ['name' => $invalidUrl];
        $response = $this->post(route('urls.store'), ['url' => $data]);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('urls', $data);

        DB::table('urls')->insert([
            [
                'name' => "https://test.ru",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        $existData = ['name' => "https://test.ru/"];
        $response = $this->post(route('urls.store'), ['url' => $existData]);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', ['name' => "https://test.ru"]);
    }
}
