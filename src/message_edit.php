<?PHP
require "config.php";
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    die();
}

$message = new Message();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new-message-content']) && !empty($_POST['new-message-content']) && isset($_POST['new-message-conversation']) && isset($_POST['message_id'])) {
    $message_edit = $_POST['new-message-content'];
    $mess = $message->updateMessage(intval($_POST['message_id']), $message_edit);
    header("Location: " . $_SESSION['page']);
    die();
}

if(isset($_GET['id'])) {


$message_current = $message->getMessage($_GET['id']);
} else{
    header("Location: " . $_SESSION['page']);
    die();
}

require "partials/header.php";
require "partials/menu.php";
?>


<div class="new-message">
    <form class="new-message-form" method="post" action="message_edit.php">
        <label for="new-message-image" class="new-message-image-label">
            <input id="new-message-image" type="file" name="new-message-image" />
            <input type="hidden" name="message_id" value="<?php echo $message_current->id;?>"/>
        </label>
        <p class="new-message-content-wrapper">
            <input class="new-message-content" name="new-message-content" type="text" data-emojiable="true" data-emoji-input="unicode" value="<?php echo $message_current->message;  ?>" />
        </p>
        <input type="hidden" name="new-message-conversation" value="<?php echo $message_current->conversation_id; ?>" />
        <button class="button-image" type="submit">
            <img src="images/bouton-send-resize.png" alt="Send" />
        </button>
    </form>
</div>

<script>
    // Initializes and creates emoji set from sprite sheet
    window.emojiPicker = new EmojiPicker( {
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: '../lib/emoji-picker/img/',
        popupButtonClasses: 'fa fa-smile-o'
    } );
    // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
    // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
    // It can be called as many times as necessary; previously converted input fields will not be converted again
    window.emojiPicker.discover();
</script>
<?php require "partials/footer.php";?>
