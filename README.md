# Laravel-Vue-SPA-CRUD
Laravel과 vue를 사용한 SPA CRUD 입니다.  

제출자 김태현   
깃 클론시  

        git clone https://github.com/thxogusrla3/Laravel-Vue-SPA-CRUD.git
        composer install
        npm install
        *npm install warn deprecated 발생시
        - npm install webpack --save
        - npm audit fix --force
        - npm install
        cp .env.example .env(.env DB 수정)
        php artisan key:generate
        (.env 설정 후) php artisan migrate

---
# Setting
- os: Ubuntu 18.04
- language: PHP
- Database: Mysql, Redis
- FrameWork: Laravel, Vue.js, PHPUnit
- VSCODE

---
# Laravel & Vue Setting
    composer create-project --prefer-dist laravel/laravel 이름
    composer require laravel/ui
    composer require predis/predis
    php artisan ui vue
    npm install
    npm install vue-router vue-axios --save
    npm run dev
    npm run watch

---
# Setting Error
#### 1. composer create-project 속도가 느릴 시
    composer clear-cache

#### 2. npm install 후 warn deprecated 발생
    npm install webpack --save
    npm audit fix --force
    npm install

#### 3. 새 데이터베이스 변경 시 오류
    php artisan config:cache

---
# SPA(단일 페이지 어플리케이션)
클라이언트가 웹 페이지를 접근하게 되면 서버로부터 초기 request가 전달한다.  
서버는 클라이언트에게 받은 request에 응답하여 초기 화면을 보여준다.  
클라이언트는 이벤트를 발생시키고 이벤트에 해당하는 데이터들이 AJAX에 담기며 서버로 전달한다.  
서버는 AJAX 요청에 응답하여 원하는 데이터를 JSON 형식으로 클라이언트에게 전달한다.  

### 장점
- 화면을 리로딩 할 필요가 없다.(JSON 형태로 비동기 요청을 주고 받기 때문)
- 클라이언트에게 진입장벽이 높지 않은 서비스를 제공할 수 있다.

### 단점
- SPA는 js의 영향이 크기 때문에 검색 엔진 최적화에 어려움이 있다.
- 초기 구동 속도가 느리다.
---
# Test-driven Development(TDD)
만드는 과정에서 우선 테스트를 작성하고 그걸 통과하는 코드를 만들고를 반복하면서 제대로 동작하는지에 대한 피드백을 적극적으로 수용하는 것이다.

## Laravel Vue TDD 예시
- Testing: vendor/bin/phpunit --filter 이름 

#### 데이터베이스 셋팅 전 클라이언트가 게시글을 추가하는 경우를 테스트
- Test code 작성

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
    
- 진행

        vendor/bin/phpunit --filter a_book_can_be_added 
        // 오류 name author 컬럼을 찾을 수 없음

        //해결1. create_books_table.php 이동
        $table->string('name');
        $table->string('author');

        php artisan migrate

        vendor/bin/phpunit --filter a_book_can_be_added 
        // 오류 Post method의 경로를 찾을 수 없음.

        //해결2. api.php로 이동
        Route::post('api/book/add', 'BookController@add); 추가

        vendor/bin/phpunit --filter a_book_can_be_added 
        // 오류 Post method의 경로를 찾을 수 없음.

        //해결3. BookController.php 이동 코드 추가
        
        public function add(Request $request)
        {
            Book::create([
                'name' => $request->input('name'),
                'author' => $request->input('author')
            ]);

            return response()->json("add success");
        }

        vendor/bin/phpunit --filter a_book_can_be_added
        // 성공(초록색 줄) 테스트 종료

---
# Redis
NOSQL(비관계형 데이터베이스)의 종류 중 하나로 Key-Value 구조로 데이터를 메모리에 저장하는 데이터 관리 시스템이다.  
메모리에 데이터가 저장되기 때문에 빠른 Read와 Write 속도를 보장한다. 또한 Master-Slave 구성이 가능하여 데이터 분실 위험을 없애준다.  
데이터 형식으로는 String, Set, sorted Set, Hash, List 를 지원한다.  

### Memcached와 Redis 비교
속도는 둘 다 차이가 없지만 Redis는 디스크와 메모리에 저장되기 때문에 메모리에만 저장하는 Memcached와는 달리 프로세스가 종료되어도 데이터를 복구할 수 있다.  
메모리 재사용에서 Memcached는 메모리를 재사용하지만 Redis는 재사용하지 않는다. Redis는 명시적으로 삭제해야만 데이터가 삭제된다.

### Redis 장점
- 리스트나, 배열과 같은 데이터 처리에 유용하다.
- 메모리를 활용하면서 영속적인 데이터 보존이 가능하다.
- redis-server는 1개의 싱글 쓰레드로 수행되며, 따라서 서버 하나에 여러개의 서버를 띄우는 것이 가능하다.

### Laravel Redis 연동
- Composer에 추가 후 연동

        composer require predis/predis
        
        //config/database.php 이동 후 수정
        'client' => env('REDIS_CLIENT', 'predis'),

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
            'read_write_timeout' => 60,
        ],
        
- Redis & Cache 설정

        //config/cache.php
        'default' => env('CACHE_DRIVER', 'redis'),
        
        //config/session.php
        'driver' => env('SESSION_DRIVER', 'redis'),
        
        //.env
        CACHE_DRIVER=redis
        
- Controller에 Redis & Cache 사용 코드

        public function index()
        {
            $books = Book::all()->toArray();
            
            Cache::put('books', $books);
            
            $all_book = Cache::get('books');
            
            return $all_book;
        }

        public function add(Request $request)
        {
            $redis = Redis::connection();
            $book = Book::create([
                'name' => $request->input('name'),
                'author' => $request->input('author')
            ]);

            $redis->append('books', $book);
            return response()->json("add success");
        }
        
- redis-cli에서 Key-Value 확인

        redis-cli // 터미널에 입력
        select 0 
        keys * //전체 키 출력
        get key이름 //키에 대한 Value 값 출력
    
