<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
require_once('vendor/autoload.php');
if (isset($_POST['submitf'])) {
    $email = $_POST['Email'];
    $tag = 'contact us page villa';
    $fname = $_POST['Name'];
    $phone = $_POST['Phone'];
    $comment = $_POST['Message'];
    $client = new MailchimpMarketing\ApiClient();
    $client->setConfig([
        'apiKey' => '980098849941b59e95b69f334e1edc2b-us2',
        'server' => 'us2'
    ]);
    try {

        $response = $client->lists->addListMember("30472033f3", [
            "email_address" => $email,
            "status" => "subscribed",
            'tags'  => array($tag),
            'merge_fields' => array('FNAME' => $fname, 'MMERGE3' => $comment, 'PHONE' => $phone),
        ]);

        if ($response) {
            $success = '<div class="alert alert-success" role="alert">User succesfully subscribed!</div>';
        }
    } catch (MailchimpMarketing\ApiException $e) {
        $success = '<div class="alert alert-danger" role="alert">User not subscribed!</div>';
        print_r($e->getMessage());
    } catch (ClientErrorResponseException $e) {
        $success = '<div class="alert alert-danger" role="alert">User not subscribed!</div>';
        print_r($e->getMessage());
    } catch (GuzzleHttp\Exception\ClientException $e) {
        $success = '<div class="alert alert-danger" role="alert">User already added to the list!</div>';
        $error_array[] = $e->getMessage();
    }
}
?>
<?php if (isset($success)) {
    echo $success;
} ?>
<div class="container">
    <form action="" method="post">
        <div class="row">
            <div class="form-group col-6">
                <label>Your Name:</label>
                <input type="text" class="form-control" maxlength="256" name="Name" placeholder="Your Name" required>
            </div>
            <div class="form-group col-6">
                <label>Your Email:</label>
                <input type="email" class="form-control" maxlength="256" name="Email" placeholder="Your Email" required>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-6">
                <label>Your Phone:</label>
                <input type="tel" class="form-control" maxlength="256" name="Phone" placeholder="Your Phone" required>
            </div>
            <div class="form-group col-6">
                <label>InquIry Type:</label>
                <div class="select-wrapper">
                    <select id="Location" name="Location" class="form-control" required>
                        <option value="Stay">Stay</option>
                        <option value="Dine">Dine</option>
                        <option value="Celebration">Celebration</option>
                        <option value="Exploration">Exploration</option>
                        <option value="Retreats">Retreats</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="input-wrapper col-12">
                <label>Message:</label>
                <textarea placeholder="I’d like to talk with you about..." maxlength="5000" name="Message" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-3">
                <button type="submit" class="btn btn-dark btn-block" name="submitf">SUBMIT</button>
            </div>
        </div>
    </form>
</div>