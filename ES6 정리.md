# JavaScript와 EcmaScript 6(2015)
  
## JavaScript Engines

- JavaScript로 작성된 코드를 해석하고 실행하는 JIT Compile 유형의 인터프리터

### JIT Compile (Dynamic Translation)

- 프로그램을 실제 실행하는 시점에 기계어로 번역
- 실행시점에 기계어를 생성하면서 그 코드를 캐싱

### 종류

- V8 (Google, Opera)
- Rhino (Mozilla)
- JavascriptCore (Safari)

### Engine 과 Runtime

- Chrome과 Node.js는 모두 같은 V8 엔진으로 JS를 실행하지만, Runtime이 다르기 때문에 실행 중 기본으로 사용할 수 있는 라이브러리가 다르다.
  - ex. alert(), global 변수 등

--------

## ES6 간단 개념

### Destructuring Assignment (비구조화 할당, 구조 분해 할당)

- 구문은 배열이나 객체의 속성을 해체하여 그 값을 개별 변수에 담는 표현식

- ES5

  ``` JS
  var name = req.body.name
  var age = req.body.age
  var email = req.body.email

  var _ref = [1, 2, 3];
  var a = _ref[0];
  var b = _ref[2];

  var _getASTNode = getASTNode();
  var a = _getASTNode.op;
  var b = _getASTNode.lhs.op;
  var c = _getASTNode.rhs;

  function g(arg) {
    var x = arg.name;
    console.log(x);     //5
  }
  g({ name: 5 });
  ```

- ES6

  ``` JS
  //object matching shorthand
  const {name, age, email} = req.body

  //object matching
  let { op: a, lhs: { op: b }, rhs: c } = getASTNode();
      //a=op, b=lhs.op, c=rhs

  //in parameter position
  function g({name: x}) {
    console.log(x);     //5
  }
  g({name: 5})

  //list matching
  let [a, , b] = [1,2,3];       //a=1, b=3
  [a, b] = [b, a];

  //Fail-soft destructuring
  var [a] = [];
  a === undefined;

  //// Fail-soft destructuring with defaults (디폴트 값 설정)
  var [a = 1] = [];
  a === 1;
  ```

- Fail-soft destructuring
  - Destructuring 으로 변수를 선언할때 값이 없으면 undefined 가 입력
  - default 값을 넣어줄 수도 있다 ```var [a = 1] = [];```

---

### Object Initialize (객체 초기자) - Property Shorthand

- ES5

  ``` JS
  var name = 'hak'
  var age = 27
  var email = 'code.ryan.lee@gmail.com'

  var datas = {
    name: name,
    age: age,
    email: email
  }
  ```

- ES6

  ``` JS
  let name = 'hak'
  let age = 27
  let email = 'code.ryan.lee@gmail.com'

  let datas = {name, age, email}
  let datas2 = {username: name, age, email}
  ```

---

### Enhanced Object Literals (향상된 객체 리터럴)

- ES5

  ```JS
  var serviceBase = {port: 3000, url: 'azat.co'},
      getAccounts = function(){return [1,2,3]}

  var accountServiceES5ObjectCreate = {
    getAccounts: getAccounts,
    toString: function() {
      return JSON.stringify(this.valueOf())
    },
    getUrl: function() {return "http://" + this.url + ':' + this.port},
    valueOf_1_2_3: getAccounts()
  }

  accountServiceES5ObjectCreate.__proto__ = Object.create(serviceBase)
  //serviceBase를 확장하길 원한다면 Object.create 로 프로토타입화하여 상속
  ```

- ES6

  ```JS
  var serviceBase = {port: 3000, url: 'azat.co'},
      getAccounts = function(){return [1,2,3]}

  var accountService = {
      __proto__: serviceBase,
      getAccounts,
      toString() {
      return JSON.stringify((super.valueOf()))
      },
      getUrl() {return "http://" + this.url + ':' + this.port},
      [ 'valueOf_' + getAccounts().join('_') ]: getAccounts()
  };
  ```

1. ```__proto__``` 속성을 사용해서 바로 프로토타입을 설정
2. 변수명만으로 이름 및 값을 지정 (```getAccounts: getAccounts```, 대신 ```getAccounts```, 를 사용)
3. 동적으로 속성 이름을 정의 (```[ 'valueOf_' + getAccounts().join('_') ]```)
4. 함수 선언시 그대로 속성으로 지정 (```getUrl()```)

---

### Template Literals (템플릿 리터럴)

- ``` ` ``` 를 사용한다.
- 여러 줄에 걸쳐 문자열을 작성할 수 있으며 모든 white-space는 있는 그대로 적용
- 문자열 인터폴레이션(String Interpolation)
  - `${ … }`으로 표현식을 감싼다. 문자열 인터폴레이션 내의 표현식은 문자열로 강제 타입 변환

- ES5
  
  ```JS
  var username = req.body.username
  if ( !username ) {
      throw "'username' must required. Your input: " + username  + "."
  }
  ```

- ES6

  ``` JS
  let {username} = req.body
  if ( !username ) {
      throw `'username' must required.
  Your input: ${username}.`             //멀티 라인 문자열 가능
  }
  ```

---

### Default Parameters (기본 매개변수)

- 매개변수의 기본 값을 설정할 수 있다.

- ES5
  
  ``` JS
  var greeting = function(username, date, message) {
      username = typeof username !== 'undefined' ? username : 'anonymous'
      date     = typeof date     !== 'undefined' ? date     : new Date()
      message  = typeof message  !== 'undefined' ? message  : 'hello'

      return message + ' ' +  username + ' at ' + date
  }
  ```

- ES6

  ```JS
  const greeting = (username='anonymous', date=new Date(), message='hello') => {
      return `${message} ${username} at ${date}`
  }
  ```

---

### Rest & Spread (가변길이 인수 및 인자)

#### Rest

- 가변길이 매개변수 ```function fun(...param)```
  - 가변길이 매개변수는 배열로 자동 치환된다.

- ES5

  ```JS
  function sum() {
    var result = 0;
    for (var i = 0; i < arguments.length; i++) {
      result += arguments[i];
    }
    return result;
  }

  console.log(sum(1, 2, 3, 4)); // 10
  ```

- ES6
  
  ```JS
  function sum(...numbers) {
    return numbers.reduce(function(a, b) { return a + b; });
  }

  console.log(sum(1, 2, 3, 4)); // 10
  ```

#### Spread

- 배열이나 문자열과 같은 인자를 매개변수의 요소순서에 맞게 할당 ```fun(...arg)```
- apply() 대체

- ES5

  ```JS
  function myFunction(x, y, z) { }
  var args = [0, 1, 2];
  myFunction.apply(null, args);
  ```

- ES6
  
  ```JS
  function myFunction(x, y, z) { }
  var args = [0, 1, 2];
  myFunction(...args);
  ```

---

> ### if-else Error-First
>
> - Bad case - Non Error First
>
>   ``` JS
>   const error = (name, age, email) => {
>       if ( name && name.length > 3 ) {
>           if ( age < 30 ) {
>               if ( /이메일정규식/.test(email) ) {
>                   return true
>               } else {
>                   return false
>               }
>           } else {
>               return false
>           }
>       } else {
>           return false
>       }
>   }
>   ```
>
> - Good case - Error First
>
>   ``` JS
>   const error = (name, age, email) => {
>       if ( !name || name.length < 4 ) {
>           return false
>       }
>
>       if ( age >= 30 ) {
>           return false
>       }
>
>       if ( !/이메일정규식/.test(email) ) {
>           return false
>       }
>
>       return true
>   }
>   ```
>
> - 기존 코드를 바꿀 때, 변경되는 조건문은 이전 조건문과 상호배타적 이어야한다.

> ### underscore.js (or lodash.js)
>
> - 데이터를 쉽고 잘 다룰수 있는 함수 지향 라이브러리
>
> ``` JS
>  const users = [
>      {
>          name: lsh,
>          age: 27,
>          job: Programmer
>      },
>      {
>          name: Kendrick,
>          age: 30,
>          job: Rapper
>      },
>      {
>          name: statham,
>          age: 50,
>          job: Actor
>      }
>  ]
>
>  _.pluck(users, 'name');
>  // =>['lsh', 'Kendrick', 'statham']
>
>  _.pluck(users, 'job');
>  // =>['Programmer', 'Rapper', 'Actor']
>  _.groupBy(['one', 'two', 'three'], 'length');
>  // => {3: ["one", "two"], 5: ["three"]}
>
>  _.contains([1, 2, 3], 3);
>  // => true
>
>  _.compact([0, 1, false, 2, '', 3]);
>  // => [1, 2, 3]
>
>  _.pairs({one: 1, two: 2, three: 3});
>  // => [["one", 1], ["two", 2], ["three", 3]]
>
>  _.pick({name: 'moe', age: 50, userid: 'moe1'}, 'name', 'age');
>  // => {name: 'moe', age: 50}
>
>  _.omit({name: 'moe', age: 50, userid: 'moe1'}, 'userid');
>  // => {name: 'moe', age: 50}
>  ```

---

---

## ES6 중요개념

### Iteration (이터레이션)

#### Iterator protocol (이터레이션 프로토콜)

- 데이터 컬렉션을 순회하기 위한 protocol
- 이터레이션 protocol을 준수한 객체는
  1. for…of 문으로 순회 가능
  2. Spread 문법의 피연산자가 될 수 있다.

#### Iterable (객체)

- iterable protocol을 준수한 객체를 iterable이라 한다.
- iterable은 `Symbol.iterator` 메소드를 구현하거나 상속한 객체
  - Array, String, Map, Set, Arguments
  - 일반 객체는 Symbol.iterator 메소드를 소유하지 않는다. 따라서 일반 객체는 iterable이 아니다.
    - 일반 객체도 iterable protocol을 준수하도록 구현하면 iterable이 된다.
- `Symbol.iterator` 메소드는 iterator를 반환

```JS
const array = [1, 2, 3];

// 배열은 Symbol.iterator 메소드를 소유한다.
// 따라서 배열은 iterable protocol을 준수한 iterable이다.
console.log(Symbol.iterator in array); // true

// iterable protocol을 준수한 배열은 for...of 문에서 순회 가능하다.
for (const item of array) {
  console.log(item);
}
```

#### Iterator

- **Iterable 객체 내부의 `Symbol.iterator` 메소드 호출시 반환되는 객체**

- next 메소드 : iterable의 각 요소를 순회하기 위한 포인터
  1. 해당 iterable(객체)을 순차적으로 한 단계씩 순회
  2. value, done 프로퍼티를 갖는 `iterator result 객체`를 반환

```JS
// 배열은 iterable protocol을 준수한 iterable이다.
const array = [1, 2, 3];

// Symbol.iterator 메소드는 iterator를 반환한다.
const iterator = array[Symbol.iterator]();  //iterator 반환

// iterator는 next 메소드를 갖는다.
console.log('next' in iterator); // true

// iterator의 next 메소드를 호출하면 value, done 프로퍼티를 갖는 result 객체를 반환.
let iteratorResult = iterator.next();
console.log(iteratorResult); // {value: 1, done: false}
```

#### 커스텀 Iterable

- 일반 객체에 `[Symbol.iterator]`를 정의하여 Iterable 객체로 만든다.

```JS
const fibonacci = {
  // Symbol.iterator 메소드를 구현하여 iterable protocol을 준수
  [Symbol.iterator]() {
    let [pre, cur] = [0, 1];
    const max = 10;         // 최대값

    // Symbol.iterator 메소드는 next 메소드를 소유한 iterator를 반환해야 한다.
    // next 메소드는 iterator result 객체를 반환
    return {
      // fibonacci 객체를 순회할 때마다 next 메소드가 호출된다.
      next() {
        [pre, cur] = [cur, pre + cur];
        return {
          value: cur,
          done: cur >= max
        };
      }
    };
  }
};

// iterable의 최대값을 외부에서 전달할 수 없다.
for (const num of fibonacci) {
  // for...of 내부에서 break는 가능하다.
  // if (num >= 10) break;
  console.log(num); // 1 2 3 5 8
}
```

---

### for..of 반복문

- iterator 기반의 컬렉션 전용 반복문
  - for of 구문을 사용하기 위해선 컬렉션 객체가 [Symbol.iterator] 속성을 가지고 있어야 한다.(즉, iterable protocol을 준수하는 iterable이어야 한다.)
- 내부적으로 iterator의 next 메소드를 호출하여 iterable을 순회
- next 메소드가 반환한 iterator result 객체의 value 프로퍼티 값을 for…of 문의 변수에 할당

```JS
// 배열
for (const item of ['a', 'b', 'c']) {
  console.log(item);
}

/***********************************************
for…of 문이 내부적으로 동작하는 것을 for 문으로 표현
***********************************************/

// iterable 객체
const iterable = [1, 2, 3];

// iterator
const iterator = iterable[Symbol.iterator]();

for (;;) {
  // iterator의 next 메소드를 호출하여 iterable을 순회한다.
  const res = iterator.next();

  // next 메소드가 반환하는 iterator result 객체의 done 프로퍼티가 true가 될 때까지 반복한다.
  if (res.done) break;

  console.log(res);
}
```

> #### for …in 반복문
>
> - for in 반복문은 객체의 속성들을 반복.
> - 모든 객체에서 사용이 가능
> - for in 구문은 객체의 key 값에 접근할 수 있지만, value 값에 접근하는 방법은 제공하지 않음
> - for in 구문은 `[[Enumerable]]` true로 셋팅되어 속성들(열거형 속성)만 반복 가능.
>
> ```JS
> var obj = {
>   a: 1, b: 2, c: 3
> };
>
> for (var prop in obj) {
>   console.log(prop, obj[prop]); // a 1, b 2, c 3
> }
> ```
>
>> #### for in 반복문과 for of 반복문의 차이점
>>
>> - for in 반복문 : 객체의 모든 열거 가능한 속성에 대해 반복. key로 반복
>> - for of 반복문 : `[Symbol.iterator]` 속성을 가지는 컬렉션 전용. value로 반복
>>
>> ```JS
>> Object.prototype.objCustom = function () {};
>> Array.prototype.arrCustom = function () {};
>>
>> var iterable = [3, 5, 7];
>> iterable.foo = "hello";
>>
>> for (var key in iterable) {
>>   console.log(key); // 0, 1, 2, "foo", "arrCustom", "objCustom"
>> }
>>
>> for (var value of iterable) {
>>   console.log(value); // 3, 5, 7
>> }
>> ```

> #### foreach 반복문
>
> - 오직 Array 객체에서만 사용가능한 메서드.(ES6부터는 Map, Set 등에서도 지원)
> - 배열의 요소들을 반복하여 작업을 수행
> - 인자로 callback 함수를 등록할 수 있고, 배열의 각 요소들이 반복될 때 callback 함수가 호출
>   - callback 함수에서 배열 요소의 인덱스와 값에 접근
>
> ```JS
> var items = ['item1', 'item2', 'item3'];
>
> items.forEach(function(item) {
>   console.log(item);
> });
> ```

---

### 비동기 처리 (Promise - Generator - Co - async/await)

- 모든 비동기 함수는 Promise를 반환하도록 한다.
  - 즉, 기존의 callback 스타일로 작성해도 되는 간단한 코드들도 모두 promise를 반환한다.
  - Promise는 미래에 생성되는 값을 나타내는 일급 객체.
  - **최종적으로는 이를 통해서 Promise - CO를 사용한 Generator - async/await 로 이어지게끔(리팩토링 가능하게끔) 하는 것이 목적**

#### Promise

- 비동기처리를 행하는 함수는 Promise를 반환, 부른 쪽에서는 Promise에 콜백 함수를 등록한다.

1. 대기중(pending) : 이행하거나 거부되지 않은 초기 상태.
2. 이행됨(fulfilled) : 연산이 성공적으로 완료
3. 거부됨(rejected) : 연산이 실패

```JS
var promiseTest = (num) => {
    return new Promise((resolve, reject) => {
        if (num > 3) {
            resolve(num)
        } else {
            reject("err")
        }
    });
}

promiseTest(5)
    .then(val => console.log(val)) // 5 (resolve)
    .catch(err => console.log(err)) //"err" (reject)
```

- ES5

  ```JS
  setTimeout(function(){
    console.log('Yay!')
    setTimeout(function(){
      console.log('Wheeyee!')
    }, 1000)
  }, 1000)
  ```

- ES6

    ```JS
    var wait1000 = () => new Promise((resolve, reject) => {
        setTimeout(resolve, 1000)
      })

    wait1000()
        .then(function() {
            console.log('Yay!')
            return wait1000()
        })
        .then(function() {
            console.log('Wheeyee!')
        });
    ```

#### Generator (function*)

- Generator는 함수안의 임의의 장소에서 처리를 중단/재개할 수 있는 구조를 제공
  - 이 구조는 일반적으로 코루틴(co-rutine)이라 불립니다.
  - 무한 리스너나 이터레이터등의 구현을 할 수 있습니다.
- 비동기 처리가 개시되면 처리를 중단, 비동기처리가 완료되면 처리를 재개한 뒤 연결 처리를 실행해 나감
- ```function*```선언을 하면 generator function을 정의한다.
  - Generator는 빠져나갔다가 나중에 다시 돌아올 수 있는 함수
    - 이때 컨텍스트(변수 값)는 출입 과정에서 저장된 상태로 남아 있다.
    - 이 함수는 Generator 객체를 반환한다.

```JS
function* generator(i) {
  yield i;
  yield i + 10;
}

var gen = generator(10);

console.log(gen.next().value);
// expected output: 10

console.log(gen.next().value);
// expected output: 20
```
  
1. 호출되어도 즉시 실행되지 않고, 대신 Generator 함수를 위한 Iterator 객체가 반환
2. Iterator의 next() 메서드를 호출하면 Generator 함수가 실행
3. yield 문을 만날 때까지 진행
4. 해당 표현식이 명시하는 Iterator로부터의 반환값을 반환
5. 이후 next() 메서드가 호출되면 진행이 멈췄던 위치에서부터 재실행

- next() 가 반환하는 객체는 아래와 같이 구성된다.
  
  ```JS
  {
    value : yield문이 반환할 값(yielded value),
    doen : Generator 함수 안의 모든 yield 문의 실행 여부(boolean)
  }
  ```

- yield* 표현식을 마주칠 경우, 다른 Generator 함수가 위임(delegate)되어 진행

  ```JS
  function* anotherGenerator(i) {
    yield i + 1;
    yield i + 2;
    yield i + 3;
  }

  function* generator(i){
    yield i;
    yield* anotherGenerator(i);
    yield i + 10;
  }

  var gen = generator(10);

  console.log(gen.next().value); // 10
  console.log(gen.next().value); // 11
  console.log(gen.next().value); // 12
  console.log(gen.next().value); // 13
  console.log(gen.next().value); // 20
  ```

#### Co 모듈

- 순정의 Generator를 사용하려면 사용상의 불편함이 있다.
- Co 모듈은 Promise, Array, Object, Generator, … 을 반환하는 함수에 yield 구문을 사용

#### async/await (ES8)

- async function 선언은 AsyncFunction객체를 반환하는 비동기 함수를 정의
- 암시적으로 Promise를 사용하여 결과를 반환

- 리팩토링 (Generator -> async/await)
  
  ```JS
  // ES6 - Generator
  const bigPicture = function* () {
    let awesome = yield beautiful()
  }

  // ES8 - async/await
  const bigPicture = async function() {
    let awesome = await beautiful()
  }
  ```

  - `function*` -> `async function`
  - `yield` -> `await`

---

### Classes

- 프로토타입 기반 객체지향 패턴을 더 쉽게 사용할 수 있는 대체재
- 클래스 패턴 생성을 더 쉽고 단순하게 생성할 수 있어서 사용하기도 편하고 상호운용성도 증가됩니다.
- 생성자(constructor) 메소드 지원. extends를 통해 상속받은 객체의 메소드를 super 를 통해 부를수도 있다.
  - 인스턴스, 정적(static) 메소드 오버라이드 등등 을 지원
  - get, set 키워드 지원

```JS
class User {
  constructor(name) {
    this._name = name;
  }

  say() {
    return 'My name is ' + this._name;
  }
}

class Admin extends User {    //클래스 상속
  say() {
    return '[Administrator] ' + super.say();
  }

  get accountsData() { //calculated attribute getter make XHR
    return this.data
  }
}

var user = new User('Alice');
console.log(user.say()); // My name is Alice

var admin = new Admin('Bob');
console.log(admin.say()); // [Administrator] My name is Bob
```

- `constructor`는 class 내부에 하나만 존재
- 메소드 정의에 function 또는 콜론(":")이 필요하지 않다.
- property의 경우 메소드와 달리 생성자에서 값을 할당

#### get

- get에 명시한 프로퍼티(get 함수명)를 가져올 때 호출되는 함수로 바인딩합니다.
  
```JS
  var obj = {
    log: ['a', 'b', 'c'],
    get latest() {
      if (this.log.length == 0) {
        return undefined;
      }
      return this.log[this.log.length - 1];
    }
  }

  console.log(obj.latest);  //output: "c"
```

#### set
  
- set에 명시한 프로퍼티(set 함수명)를 설정하려고 할 때 호출되는 함수를 바인드한다.

```JS
var language = {
  set current(name) {
    this.log.push(name);
  },
  log: []
}

language.current = 'EN';
language.current = 'FA';

console.log(language.log);  //output: Array ["EN", "FA"]
```

---

### Arrow Function

- ```=>```을 사용하는 축약형 함수 (항상 익명함수이다.)
  1. 표현식의 결과 값을 반환하는 표현식 본문 (Expression bodies)
  2. 상태 블럭 본문도 지원 (Statement bodies)
- 생성자를 사용할 수 없다.

```JS
// Expression bodies (표현식의 결과가 자동으로 반환됨)
var odds = evens.map(v => v + 1); // [3, 5, 7, 9]
var nums = evens.map((v, i) => v + i); // [2, 5, 8, 11]
var pairs = evens.map(v => ({even: v, odd: v + 1})); // [{even: 2, odd: 3}, ...]

// Statement bodies (블럭 내부를 실행만 함, 반환을 위해선 return을 명시)
nums.forEach(v => {
  if (v % 5 === 0)
    fives.push(v);
});
```

#### this

- 코드의 상위 스코프(lexical scope)를 가리키는 lexical this를 가진다.
  - 즉, arrow function을 감싸고 있는 블록을 this로 가리킨다.
- 일반 함수의 경우에는 자신을 호출한 객체를 가리키는 dynamic this
  
```JS
var bob = {
  _name: "Bob",_
  friends: ["John, Brian"],
  printFriends() {
    this._friends.forEach(f =>
      console.log(this._name + " knows " + f)  // 출력결과 : Bob knows John, Brian
    );
  }
}
```

#### 암묵적 반환(Implicit return)

- 화살표 함수의 본문(body)이 한 줄로만 구성되었다면, 반환 값 앞의 return 키워드를 생략 (표현식의 결과가 자동으로 반환)
- 몸체를 감싸는 중괄호 {}역시 생략 가능

```JS
const testFunction = () => 'hello there.';
testFunction();
```

---

### let & const

- 블록 단위의 스코프를 가진다.
  - 기존의 var는 function 단위의 스코프.
- let은 한 스코프에서 같은 이름으로 또 선언될 수 없다.
- const는 상수 처럼 사용된다.
  - 단, 담긴 값이 불변을 뜻하는게 아니라, 단지 변수의 식별자가 재할당 될 수 없다.

  - ```JS
      const ME = { "name": "ES6" }
      console.log(ME.name); //ES6

      ME.name = "ES7";
      console.log(ME.name); //ES7, 객체 값 재할당

      ME = {}; //변수 자체는 상수값으로 수정되지 않는다.
      console.log(ME); //{ name: 'ES7' }
      ```

### var를 쓰면 안되는 이유

#### 아리송한 코드

```JS
var n = 1
function test() {
  console.log(n)
  var n = 2
  console.log(n)
}
test()
```

#### 변수 호이스팅

- `var` 키워드로 변수를 선언하면 변수는 함수의 최상단으로 hoisting 된다.
  - Hoisting이란 var 키워드를 사용하여 변수를 선언 시, 해당 변수가 속한 범위(scope) 최상단으로 올려버리는 현상
  
```JS
function findUser(id) {
  if (id > 0) {
    var successMsg = "사용자를 조회하였습니다.";
    console.log(successMsg);
    console.log({ id: id, name: "사용자 #" + id });
  } else {
    var failureMsg = "잘못된 아이디입니다!";
    console.log(failureMsg);
  }
  console.log("실패 메세지:", failureMsg);
}

//변수 호이스팅을 통해 자바스크립트 엔진에는 아래와 같이 해석된다.
function findUser(id) {
  var successMsg; // hosting
  var failureMsg; // hosting

  if (id > 0) {
    successMsg = "사용자를 조회하였습니다.";
    console.log(successMsg);
    console.log({ id: id, name: "사용자 #" + id });
  } else {
    failureMsg = "잘못된 아이디입니다!";
    console.log(failureMsg);
  }
  console.log("실패 메세지:", failureMsg);
}
```

#### 자세한 예

```JS
function findUser(id, cb) {
  setTimeout(function() {
    cb({ id: id, name: "사용자 #" + id });
  }, 1000);
}

function findUsers(ids) {
  for (var i in ids) {    //문제의 부분
    findUser(ids[i], function(user) {
      console.log(i, "번째 사용자를 출력합니다.");
      console.log(user);
    });
  }
}

findUsers([3, 7, 29, 105]);
```

```JS
function findUsers(ids) {
  var i;
  for (i in ids) {
    findUser(ids[i], function(user) {
      console.log(i, "번째 사용자를 출력합니다.");
      console.log(user);
    });
  }
}
```

- var의 변수 hosting과 콜백 함수의 non blocking 성질이 만나 원치 않은 결과를 만든다.
  - let을 사용하면 자연스럽게 해결된다.

---

### Modules (import, export)

- 모듈을 호출(import)하고, 선언하여 내보낼수 있게(export)해준다.

#### export

- name export
  - 여러 개의 변수 및 함수를 export 가능
  - `{}`를 사용하며 import시에도 `{}`를 사용해야 하며 상응 하는 이름으로 import.
  - `*`를 사용하여 모든 변수를 export할 수 있다.

- default export
  - 단 하나의 변수 혹은 함수를 export.
  - `{}`를 사용하지 않아도 되며, 상응하는 이름이 없어도 import 가능.
  - 하나의 모듈당 default export는 하나만 존재할 수 있다.
  
- 외부의 다른 파일을 다시 export 할 수 있다.

```JS
// lib/math.js
export function sum(x, y) {
  return x + y;
}
export var pi = 3.141593;
```

```JS
// lib/mathplusplus.js
export * from "lib/math";
export var e = 2.71828182846;
export default function(x) {
  return Math.log(x);
}
```

```JS
// app.js
import ln, {pi, e} from "lib/mathplusplus";
console.log("2π = " + ln(e)*pi*2);
```

```JS
//name export
export { name1, name2, ..., nameN };
export { variable1 as name1, variable2 as name2, ..., nameN };
export let name1, name2, ..., nameN;    // 또는 var
export let name1 = ..., name2 = ..., ..., nameN;  // 또는 var, const

//default export
export expression;            ///////////테스트 해봐야함///////////
export default expression;
export default function (...) { ... }   // 또는 class, function* ///////////테스트 해봐야함///////////
export default function name1(...) { ... }    // 또는 class, function*
export { name1 as default, ... };

//외부의 파일을 export
export * from ...;    //모든 변수를 export
export { name1, name2, ..., nameN } from ...;
export { import1 as name1, import2 as name2, ..., nameN } from ...;
```

#### import

- as 키워드를 사용해 별칭을 사용할 수 있다.
- 절대 이름(absolute name)을 이용하여 import 하는 것도 가능
  - 절대 이름을 사용하여 import할 때는 자바스크립트가 이에 상응하는 패키지 이름을 node_modules에서 검색

  ```JS
  import React from 'react';
  ```

- 기본 값(default export 된 값)과 일반 name export 값을 같이 가져 올 경우, 기본 값을 가져오는 부분이 먼저 선언되야 합니다.

  ```JS
  import defaultMember, { member [, [...]] } from "module-name";
  ```

```JS
import name from "module-name";            ///////////테스트 해봐야함///////////

//모듈 전체 가져오기. export 된 모든 것들을 현재 범위(scope) 내에 name에 바인딩 됩니다.
import * as name from "module-name";

//해당 이름으로 name export된 멤버 가져오기
import { member } from "module-name";
import { member as alias } from "module-name";
import { member1, member2 } from "module-name";
import { member1, member2 as alias2, [...] } from "module-name";

//해당 이름으로 default export된 것 가져오기
import defaultMember from "module-name";

//default export된 것과 명시된 멤버도 같이 가져오기
import defaultMember, { member [, [...]] } from "module-name";

//default export된 것과 name export된 모든 값 가져오기
import defaultMember, * as alias from "module-name";

//특정 모듈을 불러와 실행만 할 목적
import "module-name";
```

---

---

## 참고

- [[이상학의 개발블로그] 아름다운 JavaScript를 위한 ES6](https://sanghaklee.tistory.com/54)
- [ES6의 제너레이터를 사용한 비동기 프로그래밍](https://meetup.toast.com/posts/73)
- [[JavaScript] ES6 문법 정리](https://itstory.tk/entry/JavaScript-ES6-%EB%AC%B8%EB%B2%95-%EC%A0%95%EB%A6%AC)
- [React를 배우기 전에 알아야 할 자바스크립트 기초](https://medium.com/@violetboralee/react%EB%A5%BC-%EB%B0%B0%EC%9A%B0%EA%B8%B0-%EC%A0%84%EC%97%90-%EC%95%8C%EC%95%84%EC%95%BC-%ED%95%A0-javascript%EA%B8%B0%EC%B4%88-e0665f8cbee0)
- [1주차. 30분만에 보는 ES6 필수 기초 문법](https://haviyj.tistory.com/3)
- [개발자가 필히 알아야 할 ES6 10가지 기능](https://blog.asamaru.net/2017/08/14/top-10-es6-features/)
- [신선함으로 다가온 ES6 경험](http://woowabros.github.io/experience/2017/12/01/es6-experience.html)
- [ES6시대의 JavaScript](https://gist.github.com/marocchino/841e2ff62f59f420f9d9)
- [Mozilla 재단 JavaScript 참고자료](https://developer.mozilla.org/ko/docs/Web/JavaScript/Reference)
- [let으로 변수 선언하기](https://www.daleseo.com/js-es2015-let/)
- [[자바스크립트] ES6(ECMA Script6) - export, import](https://beomy.tistory.com/22)
- [이터레이션과 for...of 문](https://poiemaweb.com/es6-iteration-for-of#3-%EC%BB%A4%EC%8A%A4%ED%85%80-%EC%9D%B4%ED%84%B0%EB%9F%AC%EB%B8%94)
- JavaScript Promise (e-book)