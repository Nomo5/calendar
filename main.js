/**
 * 指定した日付のスケジュール一覧を表示
 * @param {string} y 年
 * @param {string} m 月
 * @param {string} d 日
 */
function open_todos(y, m, d) {
    const ymd = y + '-' + m + '-' + d
    setId(ymd);
    popUpBox();

    //その日付に登録された全スケジュールを取得
    var req = new XMLHttpRequest();
    req.responseType = "json";
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            showTodos(this.response);
            return;
        }
    };
    req.open('GET', `./showTodos.php?ymd=${ymd}`, true);
    req.send();
}

/**
 * スケジュール一覧を表示
 */
function popUpBox() {
    var box = document.getElementById("box");
    
    if (box.style.display === "block") {
        location.reload();
    } else {
        box.style.display = "block";
    }
}

/**
 * 識別用にidを付与
 * @param {string} ymd year-month-day形式の日付
 */
function setId(ymd) {
    let element = document.getElementsByClassName("schedule");
    element[0].setAttribute("id", `${ymd}`);
}

/**
 * 取得したスケジュールを表示
 * @param {array} todos 
 */
function showTodos(todos) {
    for (let i = 0; i < todos.length; i++) {
        
        var textbox_element = document.getElementById("todolist1");
        var new_div_element = document.createElement('div');
        new_div_element.classList.add('todo');
        var new_element = document.createElement('li');
        new_element.id = todos[i].id;
        new_element.textContent = todos[i].todo_text;

        var new_element2 = document.createElement('button');
        new_element2.textContent = 'x';
        new_element2.onclick = function() {
            deleteTodo(todos[i].id);
        };
        new_div_element.appendChild(new_element);
        new_div_element.appendChild(new_element2);

        textbox_element.appendChild(new_div_element);
    }
}

/**
 * スケジュールの削除
 * @param {number} id 
 */
function deleteTodo(id) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
            console.log(this.response);
            alert("予定を削除しました");
            location.reload();
        }
    };

    req.open('GET', `./deletetodo.php?id=${id}`, true);
    req.send();
}

/**
 * スケジュールの追加
 */
function addTodo() {

    let licount = document.querySelectorAll('#todolist1 li').length;
    if (licount >= 10) {
        alert("登録できる予定は１０件までです。");
        location.reload();
        return;
    }

    let inputValue = document.getElementById("newtodo").value;

    //空白かどうかチェック
    if (inputValue === "") {
        alert("予定が入力されていません");
        location.reload();
        return;
    }

    document.getElementById("newtodo").value = '';

    let element = document.getElementsByClassName("schedule");
    let ymd = element[0].getAttribute("id");

    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
            console.log(this.response);
            alert("予定を追加しました");
            location.reload();

        }
    };

    req.open('POST', './addTodo.php', true);
    req.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
    req.send(`newtodo=${inputValue}&ymd=${ymd}`);
}

/**
 * スケジュール表示部分を非表示にする
 */
function hiddenBox() {
    location.reload();
}