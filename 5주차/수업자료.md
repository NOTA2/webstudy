# 5주차 - WEB2 - JavaScript

## 수업소개

- 동적으로 사용자와 상호작용 하고 싶다는 욕망으로 만들어짐

---------------------------------

## 수업의 목적

- 주간 야간 모드 버튼을 구현
    - JavaScript 코드를 사용한다.

- 웹 브라우저는 한번 표현된 화면을 바꿀 수 없다.
    - JS를 사용하여 이를 바꿀 수 있다.

### JavaScript는 HTML을 제어하는 언어이다.
- 웹을 동적(Dynamic)으로 만들어준다.

---------------------------------

## HTML과 JavaScript의 만남 1 (script 태그)

- 기본적으로 JavaScript는 HTML 위에서 동작하는 언어이다.
    - HTML 상에서 ```<script></script>```태그 내부에 JavaScript 코드를 넣는다.


```
<h1>JavaScript</h1>
<script>
    document.write(1+1);    // 2 출력
</script>

<h1>html</h1>
1+1                         // 1+1 출력
```

---------------------------------

## HTML과 JavaScript의 만남 2 (이벤트)

- 이벤트 : 웹 브라우저 위에서 일어나는 일들.
    -  특정 이벤트 발생시 미리 설정해둔 JS 코드가 실행되도록 한다.
    - JavaScript와 HTML이 상호작용하는데 핵심적인 역할을 한다.
    - onclick 속성 : 속성의 값은 JS 코드가 오고, 해당 태그가 클릭되면 속성값으로 온 JS 코드를 해석하여 동작한다.
    - onchange : 값이 바뀌는 이벤트
    - onkeydown : 사용자가 키를 눌렀을 때

```
<input type="button" value="hi" onclick="alert('hi')">
<input type="text" onchange="alert('changed')">
<input type="text" onkeydown="alert('key down!')">
```

---------------------------------

## HTML과 JavaScript의 만남 3 (콘솔)

- 웹 브라우저의 개발자 도구의 Console을 사용할 수 있다.
    - 콘솔에서 실행되는 JS 코드는 해당 웹페이지에 포함되어 있는 코드처럼 작동한다.
    - 개발자 도구 > Console탭 혹은 Elements탭에서 ESC를 통해 켯다 끌 수 있다.

---------------------------------

## 데이터타입 - 문자열과 숫자


- Number : 숫자
- String : 문자열, 여러가지 메소드들이 있다.
    - length : 문자열의 길이
    - toUpperCase() : 대문자로 반환
    - indexOf('a') : 찾고자 하는 문자열이 어디있는지 찾아준다.
    - trim() : 문자열 양 옆의 공백을 없애준다.

---------------------------------

## 변수와 대입 연산자

- var 변수명 = 값;
    - = 은 대입 연산자
    - ex. ```var x = 10;```

---------------------------------

## 웹브라우저 제어

- HTML은 한번 코드를 입력하면 화면이 고정되는 정적인 언어이다.
    - 이를 제어하려면 JavaScript를 사용해야한다.

- 즉 JS를 사용하여 body 태그의 style 속성에 값을 변화시켜야 한다.

---------------------------------

## CSS 기초

- HTML의 style 속성을 사용한다.
    - style 속성의 값은 CSS 코드이다.

- div와 span 태그 : 디자인을 위해, 특정 기능 없이 부분을 묶어주는 태그
- ```<style></style>``` 태그 : 내부의 코드는 CSS 코드이다.

### 선택자
- 특정한 태그를 선택할 때 사용된다.
    - class와 id가 있다.
        - class는 여러 태그에 적용시킬 수 있고, id는 하나의 태그에만 적용시킬 수 있다.
        - 적용 우선순위는 **tag < class < id** 이다.
```
.js {
    font-weight : bold;
}
#first{
    color : green;
}
```

---------------------------------

## 제어할 태그 선택하기

- CSS 선택자를 통해 태그 선택하기 : querySelector
    - ```document.querySelector('body')```
- 선택한 태그의 style 속성 선택
    - ```.style```
    - background-color 값 변경
        - ```.backgroundColor```
    - color 값 변경
        - ```.color```

```
document.querySelector('body').style.backgroundColor = 'black';
document.querySelector('body').style.color = 'white';
```

---------------------------------

## 프로그램, 프로그래밍, 프로그래머

- program : 순서
- programing시간의 순서에 따라서 실행되어야 할 기능을 프로그래밍 언어의 문법에 맞게 글로 적어 놓는 것. 이후 이러한 글을 실행할 때마다 컴퓨터에게 전달하는 것
    - 이후 조건에 따라 실행할 수도 있고,
    - 하나의 기능을 반복해서 실행할 수도 있고,
    - 이렇게 만들어진 기능들을 정리 할 수도 있도록 발전해 왔다.

---------------------------------

## 비교 연산자와 Boolean 데이터 타입

- ```===``` : 동등 비교 연산자. 타입까지 동시에 비교하는 등 더욱 자세히 비교한다.
    - 양 옆의 값이 같다면 ```true```, 틀리다면 ```false```
        - 이러한 값들의 데이터 타입을 **Boolean**이라고 한다.

---------------------------------

## 조건문

- 조건문 : 하나의 프로그램이 조건에 따라 다른 프로그램으로 실행되는 것.
    - boolean 값에 따라서 실행되는 코드가 달라진다.

```
if(조건){
    //true일 경우 실행
}else{
    //false일 경우 실행
}
```

---------------------------------

## 조건문의 활용

- input 태그의 value속성의 값을 기준으로 조건문을 만든다.
    - ```if(document.querySelector('#night_day').value === 'night')```

```
<input id="night_day" type="button" value="night" onclick="
    if(document.querySelector('#night_day').value === 'night'){
        document.querySelector('body').style.backgroundColor = 'black';
        document.querySelector('body').style.color = 'white';
        document.querySelector('#night_day').value = 'day';
    } else {
        document.querySelector('body').style.backgroundColor = 'white';
        document.querySelector('body').style.color = 'black';
        document.querySelector('#night_day').value = 'night';
    }
    ">
```

---------------------------------

## 리팩토링(refactoring)

- 비효율적인 부분을 지우고 새롭게 다시 만든다.
    - this : 특정 태그 내부에 포함되는 JS 코드에서 해당 태그(자기자신)를 가르키는 키워드를 사용
        - ```if(this.value === 'night')```
    - 중복을 제거해준다.
        - ```var target = document.querySelector('body');```

```
<input id="night_day" type="button" value="night" onclick="
    var target = document.querySelector('body');
    if(this.value === 'night'){
        target.style.backgroundColor = 'black';
        target.style.color = 'white';
        this.value = 'day';
    } else {
        target.style.backgroundColor = 'white';
        target.style.color = 'black';
        this.value = 'night';
    }
    ">
```

---------------------------------

## 배열 (Array)

- 연관된 데이터를 잘 정리정돈 해서 담아두는 일종의 수납상자

#### 배열 선언 및 사용
```
var coworkers = ["egoing", "leezche"];

document.write(coworkers[0]);
document.write(coworkers[1]);
```

#### 배열에 데이터 추가
```
coworkers.push('duru');
coworkers.push('taeho');
```

#### 배열의 길이
```
document.write(coworkers.length);
```

---------------------------------

## 반복문 (Loop)

#### while
```
while(조건){
    //조건이 false 될 때까지 실행될 내용
}
```

---------------------------------

## 배열과 반복문

- 배열은 연관된 데이터를 순서대로 정리한 것이고, 반복문은 배열에 담긴 데이터를 순서대로 하나씩 거내서 자동화된 처리를 할 수 있다.
    - 이 두개의 기능을 함께 사용하면 더욱 효과적이다.

```
var coworkers = ['egoing','leezche','duru','taeho'];

var i = 0;
while(i < coworkers.length){
    document.write('<li><a href="http://a.com/'+coworkers[i]+'">'+coworkers[i]+'</a></li>');
    i = i + 1;
}
```

---------------------------------

## 배열과 반복문의 활용

- 여러개의 요소(element)를 가져오는 함수 : ```document.querySelectorAll('');```

```
<input id="night_day" type="button" value="night" onclick="
    var target = document.querySelector('body');
    if(this.value === 'night'){
        target.style.backgroundColor = 'black';
        target.style.color = 'white';
        this.value = 'day';

        var alist = document.querySelectorAll('a');
        var i = 0;
        while(i < alist.length){
            alist[i].style.color = 'powderblue';
            i = i + 1;
        }
    } else {
        target.style.backgroundColor = 'white';
        target.style.color = 'black';
        this.value = 'night';

        var alist = document.querySelectorAll('a');
        var i = 0;
        while(i < alist.length){
            alist[i].style.color = 'blue';
            i = i + 1;
        }
    }
">
```

---------------------------------

## 함수

- 코드가 많아지면 이를 정리 할 수 있는 도구.
    - 중복을 제거할 수 있다.

#### 함수의 선언
```
function name(){
    //함수 실행시 실행되는 코드
}
name();     //함수 실행
```

#### 매개변수와 인자 (입력)
- 입력에 해당하는 출력을 해주는 것이 함수이다.
    - 함수로 넘겨주는 값을 인자(argument)
    - 넘겨진 값을 함수에서 사용하는 것을 매개변수(parameter)

```
function sum(left, right){
    document.write(left+right+'<br>');
}
sum(2,3); // 5
```

## 리턴 (출력)
- ```return``` 키워드를 사용.

```
function sum2(left, right){
    return left+right;
}
document.write(sum2(2,3)+'<br>');
document.write('<div style="color:red">'+sum2(2,3)+'</div>');
document.write('<div style="font-size:3rem;">'+sum2(2,3)+'</div>');
```

---------------------------------

## 함수의 활용

- ```onclick```이벤트 안에서의 ```this```는 이벤트가 소속되어 있는 태그를 가리킨다.
- 함수안에서의 ```this```는 전역객체를 가리킨다.

```
function nightDayHandler(self){
    var target = document.querySelector('body');
    if(self.value === 'night'){
        target.style.backgroundColor = 'black';
        target.style.color = 'white';
        self.value = 'day';
        var alist = document.querySelectorAll('a');
        var i = 0;
        while(i < alist.length){
            alist[i].style.color = 'powderblue';
            i = i + 1;
        }
    } else {
        target.style.backgroundColor = 'white';
        target.style.color = 'black';
        self.value = 'night';
        var alist = document.querySelectorAll('a');
        var i = 0;
        while(i < alist.length){
            alist[i].style.color = 'blue';
            i = i + 1;
        }
    }
}

<input id="night_day" type="button" value="night" onclick="
    nightDayHandler(this);
">
```

---------------------------------

## 객체

- 서로 연관된 함수와 변수를 같은 이름으로 그룹핑하여 정리정돈하는 도구
    - 윈도우의 폴더의 개념으로 생각할 수 있다.
- 같은 이름을 가진 함수가 있을 경우, 나중에 선언된 것으로 덮어쓰기된다.
    - 이름이 충돌되지 않도록 더 자세히 이름을 지정하거나 객체를 사용한다.

- 객체에 속해있는 함수는 메소드라고 부른다.

### 객체의 쓰기와 읽기
- 객체는 순서없이 데이터를 넣을 수 있다.
    - 순서 대신 데이터에 이름을 붙인다.
### 객체선언시 중괄호를 쓴다.
```
var coworkers = {
    "programmer" : "egoing",
    "designer" : "leezche"
};
```

### 객체의 데이터 사용
```
document.write("programmer : "+coworkers.programmer+"<br>");
document.write("designer : "+coworkers.designer+"<br>");
```

### 객체에 데이터 추가
```
coworkers.bookkeeper = "duru";
document.write("bookkeeper : "+coworkers.bookkeeper+"<br>");

coworkers["data scientist"] = "taeho";
document.write("data scientist : "+coworkers["data scientist"]+"<br>");
```
- 대괄호 사용시 ```"```을 안써도 되지만 그러면 띄어 쓰기가 안되기때문에 ```"```을 써주는게 좋다.

### 객체와 반복문
- ```for in```문을 사용한다.
```
for(var key in coworkers){
    //반복될 내용
}
```
- ```coworkers```의 ```key값```들을 하나씩 가져온 후 변수 ```key```에 대입하며 반복문이 실행된다.

```
for(var key in coworkers) {
    document.write(key+' : '+coworkers[key]+'<br>');
}
```

### 프로퍼티와 메소드
- 객체에는 여러 데이터 타입(변수)을 담을 수 있다. 이를 프로퍼티라고 한다.
    - 함수도 담을 수 있다. 이를 메소드라고 한다.

```
coworkers.showAll = function(){
    for(var key in this) {
        document.write(key+' : '+this[key]+'<br>');
    }
}
coworkers.showAll();
```
---------------------------------

## 객체 활용

- 각각 함수를 연관되어 있는 것들 끼리 묶어서 객체로 만든다.
    - Links 객체와 Body 객체를 만들고 이 안에 함수를 넣는다.

```
var Links = {
    setColor:function(color){
        var alist = document.querySelectorAll('a');
        var i = 0;
        while(i < alist.length){
            alist[i].style.color = color;
            i = i + 1;
        }
    }
}
```

```
var Body = {
    setColor:function (color){
        document.querySelector('body').style.color = color;
    },
    setBackgroundColor:function (color){
        document.querySelector('body').style.backgroundColor = color;
    }
}
```

```
function nightDayHandler(self){
    var target = document.querySelector('body');
    if(self.value === 'night'){
        Body.setBackgroundColor('black');
        Body.setColor('white');
        self.value = 'day';
        Links.setColor('powderblue');
    } else {
        Body.setBackgroundColor('white');
        Body.setColor('black');
        self.value = 'night';
        Links.setColor('blue');
    }
}
```


---------------------------------

## 파일로 쪼개서 정리 정돈하기

- 코드가 길어지거나 여러곳에서 쓰인다면 해당 JS 코드를 하나의 파일로 빼낸다
    - ```<script src="파일경로"></script>``` 로 불러낸다.

- 이를 통해 코드를 정리정돈 할 수 있다.
    - 유지보수가 편리해진다.
    - 캐쉬로 저장되기 때문에 비용이 절감된다.

---------------------------------

## 라이브러리와 프래임워크

- 라이브러리 : 만들고자 하는 프로그램에 필요한 부품들이 되는 소프트웨어들이 잘 정리정돈 되어 있어서 재사용하기 쉬운 것.
- 프레임워크 : 만들고자 하는 것에 따라서, 그것에 대한 공통적인 부분을 만들어 놓은것. 반제품.

### jQuery
- 생산성이 높아진다.
- 홈페이지 접속후 download 혹은 CDN을 사용한다.
    - 각각 CDN에서 제공하는 코드를 붙여놓는다.
    - ```<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>```

```
$('a').css('color', color);
```

---------------------------------

## UI vs API

- UI : 사용자와 프로그램 사이를 이어줌
- API : 프로그래머와 프로그램 사이를 이어줌

---------------------------------

## 수업을 마치며

- 프로젝트를 시작하자.
    - 모든 개념을 총 망라하지말고 필수적인 요소만으로 시작해보자.

- 추천 검색어
    - document : 태그를 삭제하거나, 자식태그를 추가하고 싶을 때
    - DOM : document 객체로도 찾을 수 없다면 DOM을 통해 검색 
    - window : 웹 브라우저 자체를 제어해야 할때
    - ajax : 웹 페이지를 리로드 하지 않고 정보를 변경하고 싶을 때
    - cookie : 웹 페이지가 리로드 되어도 현재 상태를 유지하고 싶을 때
    - offline web application : 인터넷이 끊겨도 동작하는 웹 페이지
    - webRTC : 화상통신 웹 앱
    - speech : 사용자의 음성을 인식하고, 음성으로 정보를 전달하고 싶을 때 사용하려는 api
    - webGL : 3D 그래픽을 사용하고 싶다면
    - webVR : 가상현실을 사용하고 싶다면