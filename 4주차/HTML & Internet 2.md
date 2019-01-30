# 4-1주차 - WEB1 : HTML & Internet

## 원시웹

- 우리의 또 다른 목표 내가 만든 웹페이지를 인터넷을 통해서 누구나 가져갈 수 있게 하는 것

- 웹과 인터넷은 같지 않다.

![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7724.png)

### 웹의 역사
- 정보기술 역사상 중요한 사건 2개가 1960년대와 1990년대에 있었다.
- 1960년은 인터넷이 탄생. 1990년에는 웹이 시작됩니다.
- 1960년 인터넷의 탄생
    - 1960년은 핵전쟁이 끝난 지 얼마되지 않은 때
    - 미국에서는 핵공격이 일어났을 때 통신시스템에 심각한 취약점이 있다는 것을 발견
    - 당시에는 통신 시스템이 중앙집중적이었기 때문에 핵공격을 당하면 통신이 마비되는 위험이 있었다.
    - 이런 문제를 극복하기 위해서 분산된 형태의 통신시스템을 구상하게 되는데 그것이 인터넷의 시작.
    - 수많은 통신장치가 각자 전화국 역할을 하기때문에 하나가 파괴되어도 나머지가 역할을 한다.
![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7730.jpeg)


- 1990년 웹의 탄생
    - 스위스에는 유럽입자물리 연구소(CERN)라는 저명한 연구소가 있었다.
    - 1980년 팀 버너스 리 라는 중요한 인물이 연구소에 들어온다.
    - 그는 10년동안 연구소를 들어갔다 나왔다를 반복하며 웹의 전신이 될 프로그램을 만들었다.
    - 1990년 연구소에 인터넷이 도입되었다.
    - 인터넷이 연구소에 도입되면서 팀버너스리는 지금까지의 경험에 인터넷을 합성해서 인류사적인 의미를 갖는 작업을 조용히 시작하였다.
    - 1990년 10월. 웹페이지를 편집하는 프로그램
    - 1990년 11월. 세계 최초의 웹브라우저
        - 이 웹브라우저의 이름이 바로 월드 와이드 웹(world wide web)
    - 1990년 12월 24일 크리스마스 이브에 마침내 웹서버를 완성
        - 이 서버에 info.cern.ch라는 도메인 네임을 부여

#### 인터넷이 등장한 1960년 이후로 엘리트 시스템이었던 인터넷이 1990년 웹을 만나면서 본격적인 대중화의 길을 걷기 시작

- 팀 버너스 리가 처음으로 창조한 웹은 **원시웹**
    - 웹이기 위해서 필요한 것을 모두 가지고 있으면서 그렇지 않은 것은 배제한 순수한 상태
    - 우리는 원시웹을 만들수 있다.
    - 이제 내가 만든 웹 페이지를 인터넷을 통해서 전세계의 누구나 볼 수 있도록 해야 한다.

---------------------------------

## 인터넷을 여는 열쇠 : 서버와 클라이언트

![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7752.jpeg)


1. 웹브라우저가 설치된 컴퓨터는 인터넷을 통해서 전기적인 신호를 info.cern.ch라는 주소의 컴퓨터에게 찌릿하고 보냅니다.
    - 그 전기적인 신호는 '나는 index.html 이라는 파일의 코드를 원합니다.'
2. info.cern.ch에 설치된 웹서버라는 프로그램이 어떤 디렉토리에서 index.html이라는 파일을 찾습니다.
3. 내용을 읽어서 전기적인 신호를 바꾼 후에 웹브라우저가 설치된 컴퓨터에 신호를 보냅니다.
4. 웹브라우저는 그 코드를 읽어서 웹페이지를 화면에 출력합니다.
5.  웹브라우저가 설치된 컴퓨터에는 index.html 파일의 내용 즉 코드가 도착합니다.


#### 서버와 클라이언트는 인터넷을 이용하는 모든 정보 시스템에 적용되는 문법.

- 웹서버에 익숙해지면 내가 만든 컨텐츠를 인터넷을 사용할 수 있는 전 세계의 누구나 사용하도록 있도록 할 수 있습니다.
    - 1 자신의 컴퓨터에 직접 웹서버를 설치 (어렵지만 많은것을 알게된다.)
    - 2 웹서버를 제공해주는 업체를 이용 (쉽지만 많은 것이 감춰져 있다.)
    - 웹호스팅으로 쉽게 목표를 달성한 후에 웹서버를 직접 설치하는 방법을 공부.

---------------------------------

## 웹호스팅 (github pages)

### [github](https://github.com)의 pages 기능

1. github 회원가입
2. 저장소(repository) 생성.
3. 파일 업로드
4. Settings > GitHub Pages 설정 > master branch 선택 > Select branch 중 master branch를 선택
5. 표시되는 주소로 접속

![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7777.jpeg)
![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7778.jpeg)

- static web hosting : HTML만을 지원하는 호스팅
    - HTML은 웹브라우저가 해석하기 때문에 서버쪽에서 특별히 해 줄 일이 없습니다. 이런 특성을 정적(static)이라고 합니다.

- 웹서버를 직접 운영하는 것에 비해서 웹호스팅을 이용하면 쉽다.
    - 단점은 인터넷의 원리가 감춰져 있다는 것입니다.
    - 하지만 현업에서 웹서버를 직접 운영하는 경우는 많지 않아요. 웹서버를 운영하기 위해서는 많은 노하우가 필요하거든요.

- 중요한 것은 github의 사용법이 아니고, 여러분이 필요한 웹호스팅을 찾아내는 능력.


---------------------------------

## 웹서버 운영하기

- 웹 서버는 Apache를 사용
    - 오픈소스이자 공공재

### 웹서버 운영 : 윈도우

- Bitnami WAMP Stack을 사용
    - 설치 후 C:\Bitnami\wampstack-** 디렉토리 확인
    - manager-windows 프로그램에서 Go to Application 버튼 클릭

- 아래는 전부 같은 주소
    - localhost
    - http://localhost/index.html
    - http://127.0.0.1/index.html

- index.html 파일은 내 컴퓨터 어디에 있을가?
    - Bitnami wampstack이 설치된 디렉토리에 보시면 apache → htdocs → index.html 의 파일

![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7925.jpeg)

#### 웹서버 사용 유무의 차이점
![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7932.jpeg)

#### 웹브라우저가 웹서버에 접속하기 위해서는 웹서버가 설치된 컴퓨터의 주소(ip 주소)를 알아야 한다.
![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7934.jpeg)


#### 사설망을 사용하여 접속해보기
![](https://s3-ap-northeast-2.amazonaws.com/opentutorials-user-file/module/3135/7942.jpeg)


### 웹서버 운영하기 : 맥

- 맥은 이미 Apache가 설치되어 있지만, 사용의 편의를 위해 Bitnami mampstack을 설치한다.
    - 이하 동일

### 웹서버 운영 : 리눅스

- 터미널에서 아래의 명령어 입력을 통해 Apache 설치
```
sudo apt-get update
sudo apt-get install apache2
```

- 아래의 명령어를 통해서 자신의 IP 확인
```
hostname -I
```

- Apache의 기본 파일은 ```/var/www/html``` 디렉토리에 있는 ```index.html```파일이다.


---------------------------------

## 수업을 마치며

- 공부를 멈추고 공부한 것을 사용하기도 좋은 때
    - 공부만 하고 공부한 것을 사용하지 않으면 나중엔 머리 속이 너무 복잡해져서 막상 코딩을 하려니 무엇을 해야할 지 모르게 됩니다.

- 처음엔 큰 기능도 쉽게 만들어지지만 뒤로 갈수록 사소한 기능 하나를 추가하는 것도 어렵게 되면서 깊은 슬럼프에 빠지게 됩니다.
    - 공부도 마찬가지


---------------------------------

## 부록 : 코드의 힘

### 동영상 삽입

- 유튜브 등 여러 동영상 서비스의 동영상을 HTML 코드로 가져올 수 있다.
    - iframe 태그

- 타인이 만든 서비스를 손쉽게 자신의 서비스에 추가하는 것.

### 댓글 기능 추가

- Disqus를 사용.
    - 회원가입 후 새로운 웹사이트 생성
    - Universal Code를 선택 > 복사 & 붙여놓기 수정
    - 웹서버를 통해 HTML을 열어야 한다.

### 채팅 기능 추가

- tawk를 사용
    - 회원가입 후 관리자 > Widget Code를 복사 & 붙여놓기
    - 웹서버를 통해 HTML을 열어야 한다.

### 방문자 분석기

- Google Analytics 사용
    - 로그인 후 New Account
    - 계정 생성 후 Tracking Code > Global Site Tag 복사 & HEAD에 붙여놓기
- 사용자가 사용하는 언어, 위치 등의 데이터를 모을 수 있다.