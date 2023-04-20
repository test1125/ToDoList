const taskName = document.querySelector(".add-task__input");
const addTask = document.querySelector(".add-task__button");
const todo = document.querySelector("#todo");
const done = document.querySelector("#done");
const handle = document.querySelector(".item__handle");
const itemTaskName = document.querySelector(".item__task-name");
const insertSpace = `<tr class="item space">
                        <td class="item__handle"></td>
                        <td class="item__task-info"></td>
                        <td class="item__complete"></td>
                        <td class="item__delete"></td>
                    </tr>`

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.add-task__input').focus();
});

function isEnter(e) {
    if(e.keyCode == 13){
        addItem();
    }
}

function addItem() {
    if (!taskName.value){
        alert("値が入力されていません。")
    } else {       
        //フォームの補完
        let order = todo.querySelectorAll('tr').length + 1;
        document.querySelector('.add-task__id-value').value = idNum;
        document.querySelector('.add-task__order').value = order;
        //タスクの追加
        let insertElm="";
        insertElm =
        `<tr id="list${idNum}" class="item offdrag">
            <td class="item__handle">
                <img class="item__drag_icon" src="drag_indicator.svg">
            </td>
            <td class="item__task-info">
            <input class="item__delete-value" type="hidden" name="delete[]" value="0">
                <input class="item__id-value" type="hidden" name="id[]" value="${idNum}">
                <input class="item__order" type="hidden" name="order" value="${order}">
                <input class="item__task-name" type="text" name="task_name[]" value="${taskName.value}">
                <input class="item__done-value" type="hidden" name="done[]" value="0">
            </td>
            <td class="item__complete">
                <button>完了</button>
            </td>
            <td class="item__delete">
                <button>削除</button>
            </td>
        </tr>`
        todo.insertAdjacentHTML("beforeend", insertElm);
        //送信
        if(login) document.addTask.requestSubmit();

        idNum++;
        taskName.value="";
    }
}

function DelAndDoneItem(event){
    // console.log(event.target);
    if (event.target.innerText == "削除") {
        let deleteItem= event.target.closest("tr");
        let id = deleteItem.id
        document.querySelector('.del-task__input').value = id;
        deleteItem.remove();
        //送信
        if(login) document.delTask.requestSubmit();
    }
    // 編集完了（Enter押下）時にフォーカスを外す
    else if(event.target.className == "item__task-name"){
        // console.log("itemTaskName");
        event.target.addEventListener("keydown", e =>{
            // console.log("keydown");
            if(e.key == "Enter") {
                e.target.blur();
            }
            event.target.addEventListener('blur', () => {
                //送信
                if(login) document.list.requestSubmit();
            })
        })
        
    }
    else if (event.target.innerText == "完了"){
        event.target.innerText="戻す"
        event.target.closest("tr").querySelector('.item__done-value').value = 1;
        let clone = event.target.closest("tr").cloneNode(true);
        let id = event.target.closest("tr");
        id.remove();
        done.appendChild(clone);
        //送信
        if(login) document.list.requestSubmit();     
    }
    else if (event.target.innerText == "戻す") {
        event.target.innerText="完了";
        event.target.closest("tr").querySelector('.item__done-value').value = 0;
        let clone = event.target.closest("tr").cloneNode(true);
        let id = event.target.closest("tr");
        id.remove();
        todo.appendChild(clone);
        //送信
        if(login) document.list.requestSubmit();
    }

}


function mouseUp() {
    if(dragged){
        // console.log("mouseUp");
        dragged.classList.replace("ondrag", "offdrag");
        dragged.style.pointerEvents ="auto";
        let insert = document.querySelector(".space");
        insert.replaceWith(dragged);
        dragged.removeAttribute('style');
        dragged = null;
        //送信
        if(login) document.list.requestSubmit();
    }

}

function mouseMove(e) {
    if(dragged){
        //trの移動中にスクロールされることを防ぐ
        e.preventDefault();
        // console.log("mouseMove");
        let cursorY = null;

        if(e.type == "mousemove"){
            cursorX = e.pageX;
            cursorY = e.pageY;
            dragged.style.top = cursorY - gapY + "px";
        }
        else if(e.type == "touchmove"){
            cursorX = e.touches[0].pageX;
            cursorY = e.touches[0].pageY;
            dragged.style.top = cursorY - gapY + "px";
        }
        let items = document.querySelectorAll('.offdrag');
        for(let elm of items){
            let draggedTop = window.pageYOffset + dragged.getBoundingClientRect().top;
            let draggedHeight = dragged.offsetHeight;
            let draggedMiddle = draggedTop + draggedHeight / 2;
            let itemTop = window.pageYOffset + elm.getBoundingClientRect().top;
            let itemBottom = window.pageYOffset + elm.getBoundingClientRect().bottom;
            let itemHeight = elm.offsetHeight;
            let itemMiddle = itemTop + itemHeight / 2;
            // 入れ替え対象決定
            if (draggedMiddle>itemTop && draggedMiddle<itemBottom) {
                //下に空白
                if(draggedMiddle<itemMiddle){
                    if(document.querySelector(".space")){
                        document.querySelectorAll(".space").forEach(space => {
                            space.remove();
                        })
                    }
                    elm.insertAdjacentHTML("afterend", insertSpace);
                }
                //上に空白
                else if(draggedMiddle>itemMiddle){
                    if(document.querySelector(".space")){
                        document.querySelectorAll(".space").forEach(space => {
                            space.remove();
                        })
                    }
                    elm.insertAdjacentHTML("beforebegin", insertSpace);
                }
            }
        }
    }
}

function mouseDown(e) {
    if(e.target.className != "item__handle"){
        return;
    }
    // console.log("mouseDown");
    dragged = e.target.closest("tr");
    //横幅を維持する
    // dragged.querySelectorAll("td").forEach(elm => {
    //     elm.style.width = `${elm.offsetWidth}px`;
    // })
    dragged.insertAdjacentHTML("afterend", insertSpace); //一段ずれるのを防ぐために挿入する
    dragged.style.zIndex = "100";
    dragged.style.position = "absolute"; //mouseMoveにおいてleft, topを指定するためにabsoluteに変える
    
    let elmX =dragged.getBoundingClientRect().left
    let elmY =dragged.getBoundingClientRect().top;

    if(e.type == "mousedown"){
        gapX = e.clientX - elmX
        gapY = e.clientY - elmY;
    }
    else if (e.type == "touchstart"){
        gapX = e.touches[0].clientX - elmX;
        gapY = e.touches[0].clientY - elmY;  
    }

    let cursorX = null;
    let cursorY = null;
    if(e.type == "mousedown"){
        cursorX = e.pageX;
        cursorY = e.pageY;
    }
    else if(e.type == "touchstart"){
        cursorX = e.touches[0].pageX;
        cursorY = e.touches[0].pageY;
    }
    dragged.style.left = cursorX - gapX + "px";
    dragged.style.top = cursorY - gapY + "px";

    //PC
    document.addEventListener('mousemove', mouseMove);
    document.addEventListener('mouseup', mouseUp);
    //スマホ 
    document.addEventListener('touchmove', mouseMove, {passive:false}); //passive:falseはe.preventDefault()を行うため
    document.addEventListener('touchend', mouseUp);
}

document.addEventListener('mousedown', mouseDown);
document.addEventListener('touchstart', mouseDown);

addTask.addEventListener("click", addItem);
taskName.addEventListener("keydown", isEnter);
todo.addEventListener("click", DelAndDoneItem);
done.addEventListener("click", DelAndDoneItem);


//リダイレクトを避ける
// document.querySelector(".add-task__form").addEventListener("submit", (event)=> {
//     // event.stopPropagation();
//     event.preventDefault();
//     }
// )