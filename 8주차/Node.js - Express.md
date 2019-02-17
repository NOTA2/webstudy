# WEB3 - Express

## 수업소개

- 순수한 Node.js만을 가지고 웹 서버를 제어하는 것은 불편하다.
    - Node.js 위에서 돌아가는 Web Framework를 개발

### Framework
- 반복적으로 등장하는 일들을 처리할 때 적은 코드와 지식으로 많은 일을 안정적으로 할 수 있게 해주는 것
- **Express** : Node.js에서 가장 유명한 Web Framework

---------------------------------------

## 실습환경 준비

[코드 다운받기](https://github.com/web-n/Nodejs)
- 필요한 모듈을 설치
    - ```npm install``` : package.json 파일 안에 있는 모듈을 설치한다.

- pm2를 사용하여 실행
    - ```pm2 start 파일이름``` : 파일을 node로 실행
        - ```--watch``` : 파일이 변경될때 마다 재시작해주는 옵션
    - ```pm2 log``` : 로그를 확인할수 있다.
    - ```pm2 list``` : 현재 실행중인 프로세스를 확인
    - ```pm2 stop 파일이름``` : 실행중인 파일을 종료

---------------------------------------

## Hello world

- express 설치
    - ```npm install express --save```
- [express getting started](https://expressjs.com/en/starter/hello-world.html)
```javascript
const express = require('express')
const app = express()

app.get('/', (req, res) => res.send('Hello World!'))

app.listen(3000, () => console.log('Example app listening on port 3000!'))
```
- express는 함수이다. 이를 실행하고 반환된 값이 app에 할당된다.
- ```app.get``` : 첫번째 인자로 사용자가 접근할 path 두번째 인자로 접근시 실행될 콜백함수를 받는다.
    - 이를 route, routing이라고 한다.
    - 사용자들이 path를 통해 들어올때 각 path에 맞는 응답을 해주는 것이다.
- ```app.listen``` : 웹서버가 실행되면서 인자로 전달한 port를 listen하게되고, 콜백함수가 실행된다. 


---------------------------------------

## 홈페이지 구현

```javascript
app.get('/', function(request, response) { 
  fs.readdir('./data', function(error, filelist){
    var title = 'Welcome';
    var description = 'Hello, Node.js';
    var list = template.list(filelist);
    var html = template.HTML(title, list,
      `<h2>${title}</h2>${description}`,
      `<a href="/create">create</a>`
    ); 
    response.send(html);
  });
});
```

- 가독성이 높아지고 코드가 정리된다.
- ```response.writeHead(200);  response.end(html);``` 대신 ```response.send(html)``` 한줄로 응답을 보낸다.

---------------------------------------

## 상세보기 페이지 구현

### Sementic URL (시멘틱 URL)
- 기존의 쿼리 스트링 방식 ```?name=value```가 아닌 path를 사용
    - ex. ```a.com/page?id=HTML``` 대신 ```a.com/page/HTML```을 사용
- 서버의 코드에서 파라미터를 받고싶은 곳에 ```:```을 사용하면 해당 자리의 값은 파라미터로 들어온다.

```
Route path: /users/:userId/books/:bookId
Request URL: http://localhost:3000/users/34/books/8989
req.params: { "userId": "34", "bookId": "8989" }
```
- ```:userId``` 와 ```:bookId```의 자리에 해당되는 ```34```와 ```8989```는 req.params을 통해서 객체로 사용할 수 있다.

```javascript
app.get('/page/:pageId', function(request, response) { 
    response.send(request.params);
});
```

---------------------------------------

## 페이지 생성, 수정, 삭제 구현

- post 방식의 경우 ```app.post```를 사용
- redirect의 코드 수정
    ```javascript
    response.writeHead(302, {Location: `/?id=${title}`});
    response.end();

    //// 아래의 코드로 수정

    response.redirect(302,'/pages/${title}');
    ```

---------------------------------------

## Express 미들웨어의 사용

- 다른 사람이 만든 소프트웨어(미들웨어)를 자신의 프로그램에 붙여서 사용할 수 있다.
    - [미들웨어](https://expressjs.com/en/resources/middleware.html)

### body-parser
- 설치 : ```npm install body-parser --save```
    - 클라이언트가 보낸 body를 파싱하여준다.
```js
var bodyParser = require('body-parser');

// form 데이터를 처리할 때는 이렇게
app.use(bodyParser.urlencoded({ extended: false }))

// json 데이터를 처리할 때는 이렇게
app.use(bodyParser.json())
```
- ```bodyParser.urlencoded({ extended: false })``` : body-parser 미들웨어가 생성되고 ```app.use```를 통해 사용할 수 있게 된다.
- body-parser 미들웨어는 사용자의 응답을 분석하여, 그에 맞는 라우터의 콜백함수를 실행한다.
    - 이를 호출하면서 콜백함수의 첫번째 인자에 body라는 property를 추가한다.
    - 이를 통해 req.body를 사용할 수 있다.

```js
app.post('/create_process', function(request, response){
    var post = request.body;
    var title = post.title;
    var description = post.description;
    fs.writeFile(`data/${title}`, description, 'utf8', function(err){
        response.writeHead(302, {Location: `/?id=${title}`});
        response.end();
    });
});
```

### compression 
- 데이터를 압축해서 전송하는 미들웨어
- 설치 : ```npm install compression --save```
```
var compression = require('compression');
app.use(compression());
```

---------------------------------------

## Express 미들웨어 만들기

- 미들웨어는 함수다.
    - 해당 함수의 첫번째 인자는 request, 두번째는 response, 세번째는 next
    - next는 다음에 실행되어야 할 미들웨어가 담겨있다.
```js
app.use(function(req,res,next){
    fs.readdir('./data', function(err, filelist){
        req.list = filelist;        //req 객체에 list 필드 설정
        next();                     //다음 미들웨어(여기선 없으니 해당 라우터)로 간다.
    })
})
```
- 해당 미들웨어가 필요 없는 라우터가 있다면 이는 낭비이다.
```
app.get('*', function(request, response, next){
  fs.readdir('./data', function(error, filelist){
    request.list = filelist;
    next();
  });
});
```
- ```*```은 모든 요청. 이제 이 코드는 get으로 들어오는 모든 요청에 대해 해당 코드를 실행한다.

#### 이때까지 사용한 app.get의 두번째 인자(함수)는 미들웨어였다.
- 프로그램은 각각의 미들웨어를 실행한 다음 라우팅을 통해 사용자가 입력한 path에 따른 코드를 실행한다.

---------------------------------------

## Express 미들웨어의 실행순서

- Application-level middleware
    - ```app.use```나 ```app.get```과 같이 application 객체에 등록된 미들웨어

- 인자로 함수를 여러개 줄 수 있으며 이는 여러개의 미들웨어를 붙이는것과 같다.
```js
app.use('/user/:id', function (req, res, next) {
    console.log('Request URL:', req.originalUrl)
    next()
}, function (req, res, next) {
    console.log('Request Type:', req.method)
    next()
})
```

- next()를 실행할때 파라미터로 ```'route'``` 준다면 이어진 함수를 실행하지 않고 다음 라우터의 미들웨어를 실행한다.
```js
app.get('/user/:id', function (req, res, next) {
    if (req.params.id === '0') next('route')      //이 경우 밑의 라우터가 실행
    else next()                                   //이 경우 이어진 다음 함수가 실행
}, function (req, res, next) {
    res.send('regular')
})

app.get('/user/:id', function (req, res, next) {
    res.send('special')
})
```

---------------------------------------

## 정적인 파일의 서비스

- 정적인 파일 : 이미지, 자바스크립트, CSS와 같은 파일

#### express가 미리 만들어 놓은 미들웨어를 사용한다.
- ```app.use(express.static('public'));```
    - public 디렉토리 안에서 정적인 파일을 찾는다.

---------------------------------------

## 에러처리

### 404에러
- 코드의 마지막에 아래의 코드를 추가한다.

```
app.use(function(req, res, next) {
    res.status(404).send('Sorry cant find that!');
});

```
- 미들웨어는 순차적으로 실행된다. 따라서 해당 코드를 마지막에 넣음으로서, 아무런 라우팅에 가지 못하고 도달할 경우 해당 미들웨어가 실행된다.

### 찾고자 하는 파일이 없는경우
- next를 사용한다.
    - 에러가 있는 경우 next를 호출할때 해당 에러를 인자로준다.
    - ```next(err)```을 주면 에러가 다음 라우터로 가지않고 에러처리를 하게된다.
- 또한 404 에러처리 코드 밑에 아래의 코드를 추가한다.
```
app.use(function (err, req, res, next) {
    console.error(err.stack)
    res.status(500).send('Something broke!')
})
```
- 콜백함수의 첫번째 인자는 next를 통해 받을 err가 있다.
- 또한 4개의 인자를 가지고 있는 함수는 express에서는 에러를 핸들링하기 위한 미들웨어로 약속되어 있다.

---------------------------------------

## 라우터

#### main.js
```js
var topicRouter = require('./routes/topic');
app.use('/topic', topicRouter)
```
- topic으로 들어오는 요청들에게 topicRouter라는 미들웨어를 달아줬다.

#### route/topic.js
```js
var express = require('express');
var router = express.Router();

router.get(':id', function(req,res){...})

module.exports = router;
```
- 해당 코드는 모두 ```/topic```으로 들어온 요청에 대한 처리이기 때문에 ```router.get(':id',...)```에서 ```/topic/:id```을 하면 안된다.

---------------------------------------

## 보안

- 항상 최신버전을 유지
- HTTPS를 사용한다.
- 쿠키를 안전하게 사용
- dependencies를 올바르게 관리
    - 어플리케이션이 사용하는 여러가지 모듈들 중에 취약점이 있을 수도 있으니 이를 잘 관리
        

### Helmet을 사용한다.
- 보안과 관련되어 있는 자주 일어나는 일들을 예방해준다.
- ```npm install helmet --save```
```
var helmet = require('helmet');
app.use(helmet());
```


---------------------------------------

## express generator
- Express 기반의 프로젝트를 할 때 기본적으로 필요한 파일과 코드를 자동으로 만들어주는 앱인 Express generator

### 준비
- ```npm install express-generator -g```
- ```express 프로젝트 폴더명``` : 해당 폴더에 express 프로젝트의 기본 파일들이 생성된다.
    - package.json에 필요한 모듈이 추가되어 있으니 해당 폴더에 들어가서 ```npm install``` 명령을 실행한다.

### 실행
- ```npm start```를 통해서 실행한다.
    - 이는 package.json 의 scripts의 start에서 지정한 스크립트를 실행하는데 기본적으로 ```node ./bin/www```로 설정되어 있다.
    - 따라서 해당 명령은 node ./bin/www와 같고 bin폴더의 www를 실행하는 것이다.

---------------------------------------

## 수업을 마치며

- Template engine
    - pug
    - [express template 문서](https://expressjs.com/en/guide/using-template-engines.html)
- Database
    - [express database 문서](https://expressjs.com/en/guide/database-integration.html)
- Middleware
    