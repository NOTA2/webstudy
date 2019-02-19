# WEB3 - Node.js & MySQL

## 수업소개

- 파일은 어느 운영체제에서나 바로 사용할 수 있고, 접근이 용이하다.
  - 하지만 파일을 통한 처리는 시간이 오래걸린다.
  - 그리고 여러가지 정보를 같이 넣기 힘들다.

- 이제는 데이터를 파일이 아닌, Database 프로그램에 저장한다.
  - MySQL을 사용한다.


----------------------------------------

## 실습준비

- [실습 코드 다운로드](https://github.com/web-n/node.js-mysql/releases/tag/1)

### 데이터베이스 설정

- 데이터베이스 접속
```
mysql -uroot -p
```

- 데이터베이스 생성 및 선택
```sql
CREATE DATABASE opentutorials;
USE opentutorials;
```

- author 테이블 생성 및 데이터 추가
```sql
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `profile` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `author` VALUES (1,'egoing','developer');
INSERT INTO `author` VALUES (2,'duru','database administrator');
INSERT INTO `author` VALUES (3,'taeho','data scientist, developer');
```

- topic 테이블 생성 및 데이터 추가
```sql
CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `topic` VALUES (1,'MySQL','MySQL is...','2018-01-01 12:10:11',1);
INSERT INTO `topic` VALUES (2,'Oracle','Oracle is ...','2018-01-03 13:01:10',1);
INSERT INTO `topic` VALUES (3,'SQL Server','SQL Server is ...','2018-01-20 11:01:10',2);
INSERT INTO `topic` VALUES (4,'PostgreSQL','PostgreSQL is ...','2018-01-23 01:03:03',3);
INSERT INTO `topic` VALUES (5,'MongoDB','MongoDB is ...','2018-01-30 12:31:03',1);
```

### Node.js 설정
- package.json을 통한 모듈 설치
  - ```npm install``` : package.json의 dependencies를 보고 필요한 모듈을 자동으로 설치한다.
- pm2를 통한 실행
  - ```pm2 start main.js --watch```

----------------------------------------

## Node.js MySQL 모듈의 기본 사용방법

- [Node.js의 MySQL 모듈](https://github.com/mysqljs/mysql)
- 설치 : ```npm install mysql --save```

```js
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'me',
  password : 'secret',
  database : 'my_db'
});

connection.connect();

connection.query('SELECT 1 + 1 AS solution', function (error, results, fields) {
  if (error) throw error;
  console.log('The solution is: ', results[0].solution);
});

connection.end();
```

1. mysql 모듈을 불러오고, 이 모듈의 함수에 객체를 넘겨줌으로써 MySQL에 접속한다.
  - 넘겨주는 객체에는 host(데이터베이스 서버의 주소), user, password, 사용할 database 정보를 담는다.
2. ```connection.connect();``` : MySQL에 접속한다.
3. ```connection.query```은 첫번째 인자로 SQL문을, 두번째 인자로 콜백함수를 준다.
  - 이러면 첫번째 인자로 전달된 SQL이 DB 서버에 전송되어, 실행이 끝난 다음에 콜백함수를 실행한다.
4. 콜백함수의 첫번째 인자는 에러, 두번째 인자는 결과가 있다.
5. ```connection.end();``` : 연결을 종료한다.

#### 이 코드를 통해 Node.js는 MySQL 클라이언트로써 동작한 것이다.

### DB 접속에 문제가 있는 경우
- ```ER_ACCESS_DENIED_ERROR```가 나타날 경우
  - DB 서버에 접속 후 ```SELECT Host,User FROM mysql.user```를 통해 유저 테이블을 살펴본다.
    - User는 DB 서버에 등록되어 있는 사용자
    - Host는 각각의 사용자들이 접속할 수 있는 클라이언트의 IP
  - User이면서 Host를 만족하는 사용자만이 접속할 수 있다.
    - 잘 안될경우 새로운 유저를 생성해야 한다.

- 유저 생성

```sql
-- 어디서든 접속해도 되는 유저를 생성(%로 해놓으면 어디서든 접속이 가능하다.)
CREATE USER '유저이름'@'%' IDENTIFIED BY '비밀번호';

-- 특정 데이터베이스의 모든 권한을 준다. (우리 실습에서는 opentutorials)
GRANT ALL PRIVILEGES ON 데이터베이스이름.* TO '유저이름'@'%';

-- 설정한 내용을 DB에 적용
FLUSH PRIVILEGES;
```

----------------------------------------

## MySQL로 홈페이지 구현

- mysql 연결 코드를 추가.
```js
var mysql = require('mysql');
var db = mysql.createConnection({
  host:'localhost',
  user:'root',
  password:'111111',
  database:'opentutorials'
});
db.connect();
```



- db에 접속하여 원하는 데이터를 가져온다.
  - 기본적인 코드는 모두 똑같다.

```js
db.query(`SELECT * FROM topic`, function(error,topics){
  var title = 'Welcome';
  var description = 'Hello, Node.js';
  var list = template.list(topics);
  var html = template.HTML(title, list,
    `<h2>${title}</h2>${description}`,
    `<a href="/create">create</a>`
  );
  response.writeHead(200);
  response.end(html);
});
```


- template.list 함수를 수정
```js
list:function(topics){
  var list = '<ul>';
  var i = 0;
  while(i < topics.length){
    //기존코드
    //list = list + `<li><a href="/?id=${filelist[i]}">${filelist[i]}</a></li>`;
    list = list + `<li><a href="/?id=${topics[i].id}">${topics[i].title}</a></li>`;
    i = i + 1;
  }
  list = list+'</ul>';
  return list;
}
```


----------------------------------------

## MySQL로 상세보기 구현

- 에러가 있는 경우 
  - 에러를 다음 코드를 실행하지 않고, 에러를 콘솔에 표시하며 프로그램을 중지시킨다.
```js
if(error){
  throw error;
}
```



- sql의 결과가 하나만 있더라도 배열에 있기 때문에 이를 신경써줘야 한다.
- sql문 작성시 변수를 사용해야 한다면, 변수가 있어야 하는 자리에 ```?```를 쓰고 query함수의 두번째 인자에 배열로 이를 전달한다.
  - ```?```부분에 배열의 값들이 치환되기 때문에 실행결과는 똑같다.
  - 하지만 공격의 여지가 있는 것들은 세탁되어서 적용되기 때문에 안전한 sql문이 된다.
  - ```db.query(`SELECT * FROM topic WHERE id=?`,[queryData.id], ...);```

```js
//먼저 글 목록을 가져온다.
db.query(`SELECT * FROM topic`, function(error,topics){
  if(error){
    throw error;
  }
  //그후 글의 상세 정보를 가져온다.
  db.query(`SELECT * FROM topic WHERE id=?`,[queryData.id], function(error2, topic){
    if(error2){
      throw error2;
    }
    var title = topic[0].title;
    var description = topic[0].description;
    var list = template.list(topics);
    var html = template.HTML(title, list,
      `<h2>${title}</h2>${description}`,
      ` <a href="/create">create</a>
        <a href="/update?id=${queryData.id}">update</a>
        <form action="delete_process" method="post">
          <input type="hidden" name="id" value="${queryData.id}">
          <input type="submit" value="delete">
        </form>`
    );
    response.writeHead(200);
    response.end(html);
  });
});
```

----------------------------------------

## MySQL로 글생성 기능 구현

- SQL문 작성
```sql
INSERT INTO topic (title, description, created, author_id)
VALUES('Nodejs', 'Nodejs is...', NOW(), 1);
```

- js 코드로 적용
```js
db.query(`
  INSERT INTO topic (title, description, created, author_id) VALUES(?, ?, NOW(), ?)`,
  [post.title, post.description, 1], function(error, result){
  if(error){
      throw error;
  }
  response.writeHead(302, {Location: `/?id=${result.insertId}`});
  response.end();
});
```
- ```NOW()``` : 현재 시간을 넣을 수 있다.
- INSERT시 삽입한 행의 id값 : ```result.insertId```


----------------------------------------

## MySQL로 글수정 기능 구현

- 수정 Form 코드 변경
```js
db.query('SELECT * FROM topic', function(error, topics){
  if(error) throw error;

  db.query(`SELECT * FROM topic WHERE id=?`,[queryData.id], function(error2, topic){
    if(error2) throw error2;
    
    var list = template.list(topics);
    var html = template.HTML(topic[0].title, list,
      `
      <form action="/update_process" method="post">
        <input type="hidden" name="id" value="${topic[0].id}">
        <p><input type="text" name="title" placeholder="title" value="${topic[0].title}"></p>
        <p>
          <textarea name="description" placeholder="description">${topic[0].description}</textarea>
        </p>
        <p>
          <input type="submit">
        </p>
      </form>
      `,
      `<a href="/create">create</a> <a href="/update?id=${topic[0].id}">update</a>`
    );
    response.writeHead(200);
    response.end(html);
  })
})
```

- 수정 처리 코드 변경
```js
db.query('
  UPDATE topic SET title=?, description=?, author_id=1 WHERE id=?', 
  [post.title, post.description, post.id],
  function(error, result){
    response.writeHead(302, {Location: `/?id=${post.id}`});
    response.end();
  }
);
```


----------------------------------------

## MySQL로 글 삭제 기능 구현

```js
db.query('DELETE FROM topic WHERE id = ?', [post.id], function(error, result){
  if(error){
      throw error;
  }
  response.writeHead(302, {Location: `/`});
  response.end();
});
```


----------------------------------------

## MySQL join을 이용해서 상세보기 구현

- 관계형 데이터베이스의 JOIN을 사용하여 현재 글의 작성자를 보여준다.
- SQL 문
```sql
SELECT * FROM topic LEFT JOIN author ON topic.author_id=author.id WHERE topic.id=1
```

- main.js 상세보기 페이지 구현
```js
db.query(`SELECT * FROM topic`, function(error,topics){
  if(error) throw error;
  
  db.query(`
    SELECT * FROM topic 
    LEFT JOIN author ON topic.author_id=author.id 
    WHERE topic.id=?`,
    [queryData.id], 
    function(error2, topic){
      if(error2) throw error2;
      
      var title = topic[0].title;
      var description = topic[0].description;
      var list = template.list(topics);
      var html = template.HTML(title, list,
        `
        <h2>${title}</h2>
        ${description}
        <p>by ${topic[0].name}</p>
        `,
        ` <a href="/create">create</a>
          <a href="/update?id=${queryData.id}">update</a>
          <form action="delete_process" method="post">
            <input type="hidden" name="id" value="${queryData.id}">
            <input type="submit" value="delete">
          </form>`
      );
      response.writeHead(200);
      response.end(html);
    }
  )
});
```


----------------------------------------

## MySQL join을 이용해서 글생성 구현

- 사용자 목록을 읽어오고 이를 콤보박스로 구현.
  - 글 작성자를 선택하도록 한다.
- main.js의 create
```js
db.query(`SELECT * FROM topic`, function(error,topics){
  db.query('SELECT * FROM author', function(error2, authors){
    var title = 'Create';
    var list = template.list(topics);
    var html = template.HTML(title, list,
    `
    <form action="/create_process" method="post">
      <p><input type="text" name="title" placeholder="title"></p>
      <p>
        <textarea name="description" placeholder="description"></textarea>
      </p>
      <p>
        ${template.authorSelect(authors)}
      </p>
      <p>
        <input type="submit">
      </p>
    </form>
    `,
    `<a href="/create">create</a>`
    );
    response.writeHead(200);
    response.end(html);
  });
});
```

- template.authorSelect 함수.
```js
authorSelect : function(authors){
  var tag = '';
  var i = 0;
  while(i < authors.length){
    tag += `<option value="${authors[i].id}">${authors[i].name}</option>`;
    i++;
  }
  return `
  <select name="author">
    ${tag}
  </select>
  `
}
```

----------------------------------------

## MySQL join을 이용해서 글수정 구현

- main.js의 update
  - create와 같이 author의 정보가 있어야한다.
  - 그리고 이를 콤보박스로 보여준다.
```js
db.query('SELECT * FROM topic', function(error, topics){
  if(error) throw error;
  
  db.query(`SELECT * FROM topic WHERE id=?`,[queryData.id], function(error2, topic){
    if(error2) throw error2;

    db.query('SELECT * FROM author', function(error2, authors){
      var list = template.list(topics);
      var html = template.HTML(topic[0].title, list,
        `
        <form action="/update_process" method="post">
        <input type="hidden" name="id" value="${topic[0].id}">
        <p><input type="text" name="title" placeholder="title" value="${topic[0].title}"></p>
        <p>
          <textarea name="description" placeholder="description">${topic[0].description}</textarea>
        </p>
        <p>
          ${template.authorSelect(authors, topic[0].author_id)}
        </p>
        <p>
          <input type="submit">
        </p>
        </form>
        `,
        `<a href="/create">create</a> <a href="/update?id=${topic[0].id}">update</a>`
      );
      response.writeHead(200);
      response.end(html);
    });
  });
});
```


- 수정시에는 create와 달리 현재글의 작성자의 정보가 있어야한다.
  - ```template.authorSelect``` 함수의 두번째인자로 현재 작성자의 정보를 전달한다.
  - ```template.authorSelect(authors, topic[0].author_id)```
  - authorSelect 함수를 수정해 준다.
```js
while(i < authors.length){
  var selected = '';
  if(authors[i].id === author_id) {
    selected = ' selected';
  }
  tag += `<option value="${authors[i].id}"${selected}>${authors[i].name}</option>`;
  i++;
}
```


- main.js의 update_process
```js
db.query(
  'UPDATE topic SET title=?, description=?, author_id=? WHERE id=?', 
  [post.title, post.description, post.author, post.id],
  function(error, result){
    response.writeHead(302, {Location: `/?id=${post.id}`});
    response.end();
});
```

----------------------------------------

## 수업의 정상

- 복잡한 코드를 정리정돈하여 보기좋게 만든다.
- 저자의 생성,수정,삭제 기능을 만든다.

----------------------------------------

## Node.js의 DB 설정정보 정리정돈

- DB접속 코드를 여러번 사용할 것이기 때문에 DB에 접속하는 코드를 따로 빼놓는다.
- ```./lib/db.js```
```js
var mysql = require('mysql');
var db = mysql.createConnection({
  host:'localhost',
  user:'root',
  password:'111111',
  database:'opentutorials'
});
db.connect();
module.exports = db;
```

- 이렇게 DB에 따로 접속하는 코드를 버전관리하면 위험하다.
  - 따라서 안은 텅텅 비어 있는 ```db.template.js```파일을 버전관리에 넣는다.
  - 이후 ```db.template.js```파일을 수정하여 ```db.js```를 만들고 이 파일은 버전관리 하지 않는다.
```js
//db.template.js 파일
var mysql = require('mysql');
var db = mysql.createConnection({
  host:'',
  user:'',
  password:'',
  database:''
});
db.connect();
module.exports = db;
```

----------------------------------------

## Node.js 코드의 정리정돈 (topic)

- 우리가 만들 모듈은 바깥쪽에서 사용할 때 여러개의 핸들(기능)을 제공할 것이기 때문에 ```module.exports```가 아닌 그냥 ```exports```를 사용한다.
  - 즉 하나의 파일에서 여러개의 api를 제공할 것이면 ```exports```를 사용
  - 그게 아니라 하나의 파일에 하나의 api만 제공한다면 ```module.exports```을 사용.

```js
//topic.js
var db = require('./db');
var template = require('./template.js');

exports.home = function(request, response){
  db.query(`SELECT * FROM topic`, function(error,topics){
    var title = 'Welcome';
    var description = 'Hello, Node.js';
    var list = template.list(topics);
    var html = template.HTML(title, list,
      `<h2>${title}</h2>${description}`,
      `<a href="/create">create</a>`
    );
    response.writeHead(200);
    response.end(html);
  });
}
```

```js
//main.js
var topic = require('./lib/topic');
...
if(pathname === '/'){
  if(queryData.id === undefined){
    topic.home(request, response);
  }else {...}
}
```

- 나머지 모든 라우터들도 이런식으로 처리하면 된다.


----------------------------------------

## 저자 관리 기능의 구현

- 저자 정보와 관련된 CRUD 코드를 작성할 것이다.

----------------------------------------

## 저자 목록 보기 기능 구현

- main.js에 author 라우터추가
```js
else if(pathname === '/author'){
  author.home(request, response);
} 
```

- author.js 추가
```js
var db = require('./db');
var template = require('./template.js');
exports.home = function(request, response){
  db.query(`SELECT * FROM topic`, function(error,topics){
    db.query(`SELECT * FROM author`, function(error2,authors){
      var title = 'author';
      var list = template.list(topics);
      var html = template.HTML(title, list,
      `
      ${template.authorTable(authors)}
      <style>
        table{
          border-collapse: collapse;
        }
        td{
          border:1px solid black;
        }
      </style>
      `,
      `<a href="/create">create</a>`
      );
      response.writeHead(200);
      response.end(html);
    });
  });
}
```

- author 표를 만들어주는 함수(```template.authorTable(authors)```)를 template.js에 추가
```js
authorTable:function(authors){
  var tag = '<table>';
  var i = 0;
  while(i < authors.length){
    tag += `
      <tr>
        <td>${authors[i].name}</td>
        <td>${authors[i].profile}</td>
        <td>update</td>
        <td>delete</td>
      </tr>
      `
    i++;
  }
  tag += '</table>';
  return tag;
}
```

----------------------------------------

## 저자 생성 기능 구현

- author.js의 home에서 바로 저자를 추가할 수 있도록 form 태그를 추가
```js
<form action="/author/create_process" method="post">
  <p>
    <input type="text" name="name" placeholder="name">
  </p>
  <p>
    <textarea name="profile" placeholder="description"></textarea>
  </p>
  <p>
    <input type="submit">
  </p>
</form>
```

- main.js에 라우터 추가
```js
else if(pathname === '/author/create_process'){
    author.create_process(request, response);
} 
```

- author.js에 create_process를 추가
```js
exports.create_process = function(request, response){
  var body = '';
  request.on('data', function(data){
    body = body + data;
  });
  request.on('end', function(){
    var post = qs.parse(body);
    db.query(`
    INSERT INTO author (name, profile) 
        VALUES(?, ?)`,
    [post.name, post.profile], 
    function(error, result){
      if(error){
        throw error;
      }
      response.writeHead(302, {Location: `/author`});
      response.end();
    }
    )
  });
}
```


----------------------------------------

## 저자 수정 기능 구현

- main.js에 라우터 추가
```js
else if(pathname === '/author/update'){
  author.update(request, response);
} else if(pathname === '/author/update_process'){
  author.update_process(request, response);
} 
```




- author.js에 수정코드 추가
  1. ```SELECT * FROM topic```으로 기본 글목록 불러오기
  2. ```SELECT * FROM author```으로 저자 목록 불러오기
  3. ```SELECT * FROM author WHERE id=?```으로 현재 수정할 저자의 정보 불러오기

```js
exports.update = function(request, response){
db.query(`SELECT * FROM topic`, function(error,topics){
  db.query(`SELECT * FROM author`, function(error2,authors){
    var _url = request.url;
    var queryData = url.parse(_url, true).query;
    db.query(`SELECT * FROM author WHERE id=?`,[queryData.id], function(error3,author){
      var title = 'author';
      var list = template.list(topics);
      var html = template.HTML(title, list,
      `
      ${template.authorTable(authors)}
      <style>
          table{
              border-collapse: collapse;
          }
          td{
              border:1px solid black;
          }
      </style>
      <form action="/author/update_process" method="post">
          <p>
              <input type="hidden" name="id" value="${queryData.id}">
          </p>
          <p>
              <input type="text" name="name" value="${author[0].name}" placeholder="name">
          </p>
          <p>
              <textarea name="profile" placeholder="description">${author[0].profile}</textarea>
          </p>
          <p>
              <input type="submit" value="update">
          </p>
      </form>
      `,
      ``
      );
      response.writeHead(200);
      response.end(html);
    });
  });
});
}

exports.update_process = function(request, response){
  var body = '';
  request.on('data', function(data){
    body = body + data;
  });
  request.on('end', function(){
    var post = qs.parse(body);
    db.query(`
      UPDATE author SET name=?, profile=? WHERE id=?`,
      [post.name, post.profile, post.id], 
      function(error, result){
      if(error){
          throw error;
      }
      response.writeHead(302, {Location: `/author`});
      response.end();
      }
    )
  });
}
```


----------------------------------------

## 저자 삭제 기능 구현

- delete를 할때는 링크로 처리하면 안된다.
  - form으로 처리해야 한다.
  - template.js에서 저자 목록을 보여주는 authorTable함수에서 삭제 버튼(form)을 추가한다.
```js
`
<td>
  <form action="/author/delete_process" method="post">
    <input type="hidden" name="id" value="${authors[i].id}">
    <input type="submit" value="delete">
  </form>
</td>
`
```

- main.js 라우터를 추가
```js
else if(pathname === '/author/delete_process'){
  author.delete_process(request, response);
} 
```

- author.js에 delete 처리 추가
  - 이때 저자가 지워지면 해당 저자의 글도 모두 지워지게 한다.

```js
exports.delete_process = function(request, response){
  var body = '';
  request.on('data', function(data){
    body = body + data;
  });
  request.on('end', function(){
    var post = qs.parse(body);
    db.query(
      `DELETE FROM topic WHERE author_id=?`,
      [post.id], 
      function(error1, result1){
        if(error1){
          throw error1;
        }
        db.query(`
          DELETE FROM author WHERE id=?`,
          [post.id], 
          function(error2, result2){
            if(error2){
              throw error2;
            }
            response.writeHead(302, {Location: `/author`});
            response.end();
          }
        )
      }
    );
  });
}
```


----------------------------------------

## 보안 - SQL Injection

- 외부로부터 들어오는 정보는 무조건 오염된 정보라는 가정을 해야 한다.
  - 사용자가 입력한 정보, 쿼리 스트링, 사용자가 올린 파일 등

### SQL Injection
- 공격의 의도를 가진 SQL 코드를 주입함으로서 공격 목적을 달성하는 기법

- query함수에 리턴값은 실제 DB에 입력된 SQL문을 담고 있다.
  - ```query.sql```을 확인하면 된다.
```js
var query = db.query('SELECT * FROM topic', function(){})
console.log(query.sql);   //SELECT * FROM topic
```

- 만약 사용자가 URL의 끝에 ```/?id=1;DROP TABLE topic```이라고 하면 이는 SQL Injection의 의도를 가지고있다.
  - 하지만 query함수의 두번째 인자의 배열의 요소로 이를 전달해 준다면 방지할 수 있다.
    - ```db.query('SELECT * ~~~~~ WHERE id=?', [id], function(){});```
  - 배열의 값을 ```?```에 치환함으로써 실제 SQL문에서는 해당 값이 따옴표(```'```)로 감싸지게 된다.

### 즉, 사용자로부터 받은 입력을 sql문에 넣어야 한다면 ?를 치환하는 방식을 쓰도록 하자!

- node의 mysql 모듈은 기본적으로 DB에게 한번에 2개 이상의 sql문을 입력하는 것을 막고 있다.
  - 단, 이를 설정을 통해서 풀어줄 수 있다.
  - ```mysql.createConnection``` 함수에게 넘겨주는 객체(접속을 설정하는 객체)에 ```multipleStatements:true```을 추가하면 된다.
```js
var mysql = require('mysql');
var db = mysql.createConnection({
  host:'localhost',
  user:'root',
  password:'111111',
  database:'opentutorials',
  multipleStatments:true
});
db.connect();
```
- 위와 같이 하면 하나의 ```db.query``` 함수에서 2개 이상의 SQL문을 질의할 수 있다.

- 이 상태에서 ``` `SELECT * FROM topic WHERE id=${queryData.id}` ```와 같은 SQL문을 넘겨준다면 (즉, ```?```를 치환하는 방법을 사용하지 않는다면)  ```db.escape``` 함수를 사용하여 데이터를 감싸준다.
  - ex. ``` id=${db.escape(queryData.id)} ```
  - ```db.escape```함수는 입력받은 데이터를 공격의 위험이 없는 코드로 바꿔준다. (따옴표(```'```)로 이를 감싸는 등)


----------------------------------------

## 보안 - Escaping

### Cross site scripting (XSS)
- Form과 같은 곳에 공격의 의도를 가진 자바스크립트 코드를 입력해서 이 코드를 웹 브라우저로 실행할 때 공격목적을 달성하는 공격 기법을

### Escaping
- 이미 저장된 정보가 바깥쪽으로 나갈때 그 안에 공격의 의도가 포함되어 있는 코드를 쳐내는 것 

### 즉 XSS 공격을 Escaping으로 막는다.
- 이를 위해 sanitize-html 모듈을 사용한다.
  - ```npm install sanitize-html --save```
  - ```var sanitizeHtml = require('sanitize-html');```

```js
exports.page = function(request, response){
  var _url = request.url;
  var queryData = url.parse(_url, true).query;
  db.query(`SELECT * FROM topic`, function(error,topics){
    if(error){
      throw error;
    }
    db.query(`SELECT * FROM topic LEFT JOIN author ON topic.author_id=author.id WHERE topic.id=?`,[queryData.id], function(error2, topic){
      if(error2){
        throw error2;
      }
      var title = topic[0].title;
      var description = topic[0].description;
      var list = template.list(topics);
      var html = template.HTML(title, list,
        `
        <h2>${sanitizeHtml(title)}</h2>
        ${sanitizeHtml(description)}
        <p>by ${sanitizeHtml(topic[0].name)}</p>
        `,
        ` <a href="/create">create</a>
          <a href="/update?id=${queryData.id}">update</a>
          <form action="delete_process" method="post">
            <input type="hidden" name="id" value="${queryData.id}">
            <input type="submit" value="delete">
          </form>`
      );
      response.writeHead(200);
      response.end(html);
    })
  });
}
```
- 사용자가 입력하는 ```title```, ```description```, ```topic[0].name```에 ```sanitizeHtml```함수를 사용하여 깜싸서 HTML함수를 만든다.

### 사용자가 입력한 정보에 대해 살균(sanitizeHtml)을 꼭 해줘야 한다.

----------------------------------------

## 수업을 마치며

- 검색 기능
  - FORM 태그를 통해 검색할 내용을 입력 받고
  - SQL SELECT문에 ```WHERE title="keyword"``` 와 같은 구무을 추가하여 해당 데이터를 찾으면된다.
  - 데이터가 너무 많아서 속도가 느려질 경우 DB의 **index(색인)** 기능을 알아보자.
- index
  - 데이터를 추가할 때 마다 빨리 찾을 수 있도록 미리 작업을 해놓는다.
  - 데이터 추가시 속도는 조금 느려지지만 검색시에는 엄청나게 빠르게 이를 찾을 수 있다.
- 정렬 기능
  - SQL SELECT문에 ```ORDER BY id DESC```와 같은 구문을 추가하여 구현할 수 있다.
- 페이지 기능
  -  SQL SELECT문에 ```LIMIT 0 OFFSET 20```와 같은 구문을 추가하여 구현할 수 있다.
- Not Only SQL (NoSQL)
  - SQL이 제공하는 기능까지만 정보기술이 구현되어 있는 경우가 많다.
  - 이러한 SQL의 한계를 넘기위해 만들어진 기술들에 대한 포괄적인 개념