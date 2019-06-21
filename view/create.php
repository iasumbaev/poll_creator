<?php $title = 'Creating post' ?>


<?php ob_start() ?>

<div class="poll">
    <h1>Polls</h1>
    <form id="app" method="post" action="poll/<?= $uri; ?>">
        <table class="my-table">
            <tr>
                <th><label for="q">Question:</label></th>
                <th><input id="q" name='question' type="text" required>
                </th>
                <th></th>
            </tr>
            <tr v-for="(input, index) in inputs">
                <td><label :for="'a'+index">Answer {{index + 1}}:</label></td>
                <td><input type="text" v-model="input.value"
                           name="answers[]"
                           :id="'a'+index"
                           required>
                </td>
                <td>
                    <button type="button" @click="deleteRow(index)" v-if="isVisibleButton" class="del-btn">Delete
                    </button>
                </td>
            </tr>
        </table>
        <button type="button" @click="addRow" class="add-btn">Add answer</button>

        <button type="submit" class="submit-btn">Start</button>
    </form>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>

<script src="resources/js/create.js"></script>
