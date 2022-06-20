//フラッシュメッセージのキャンセルボタン
$('#flash-message-cancel').on('click', () => {
    $('#flash-message').slideUp()
});

//フラッシュメッセージの自動消去
window.setTimeout(() => {
    $('#flash-message').slideUp()
}, 7000);

//生徒の削除：確認メッセージ
$("#student-delete").on('click', () => {
    if(!confirm("削除してもよろしいですか？")) {
       return false;
    }
});
