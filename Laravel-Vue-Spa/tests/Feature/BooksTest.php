<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;

class BooksTest extends TestCase
{
    // use RefreshDatabase; //테스트 시작할 때마다 데이터베이스를 초기화 하는 역할.
    use DatabaseMigrations;  //모든 테스트에 대해 필요한 경우 데이터베이스를 마이그레이션하고 테스트가 완료되면 롤백. 
    
    /** @test */
    public function books_can_be_readed()
    {
        $books = factory('App\Book')->create();

        $response = $this->get('api/books');

        $response->assertSee($books->name, false)
            ->assertSee($books->author, false);
    }

    /** @test */
    public function a_book_can_be_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/book/add',[
            'name'=>'Test name',
            'author'=>'test author',
            ]);

        $this->assertDatabaseHas('books',[
            'name' => 'Test name',
            'author' => 'test author'
        ]);
    }

    /** @test */
    public function a_book_can_be_readed(){
        $book = factory('App\Book')->create(['id'=>1]);

        $response = $this->get('/api/book/edit/'.$book->id);

        $response->assertSee($book->name, false)
            ->assertsee($book->author, false);
    }
    
    /** @test */
    public function a_book_can_be_update()
    {
        $book = factory('App\Book')->create(['id'=>1]);

        $book->name="update name";
        $book->author="update author";

        $this->post('/api/book/update/'.$book->id, $book->toArray());
        $this->assertDatabaseHas('books',[
            'name' => 'update name',
            'author' => 'update author'
            ]);
    }
    
    /** @test */
    public function a_book_can_be_delete()
    {
        $this->withoutExceptionHandling();

        $book = factory('App\Book')->create(['id'=>1]);
        
        $this->delete('api/book/delete/'.$book->id);
        
        $this->assertDatabaseMissing('books', ['id'=>$book->id]);
    }
    
}
