<?php $title = $poll->getQuestion() ?>


<?php ob_start() ?>


<div class="poll" id="app">
    <h1 ref="question" data-id="<?= $poll->getPollID() ?>"
        data-uri="<?= $poll->getUri() ?>"><?= $poll->getQuestion() ?></h1>

    <form>

        <p v-if="errors.length">
        <ul>
            <li v-for="error in errors" class="alert alert-red">{{ error }}</li>
        </ul>
        </p>

        <?php if (!isset($_COOKIE[$poll->getUri()])) : ?>

            <div class="vote" v-if="hasVoted==false">
                <div class="name">
                    <label for="name">Your name:</label>

                    <input v-model="name" id="name" name='name' type="text">
                </div>
                <div class="answers">
                    <?php $answersIDs = $poll->getAnswersID(); ?>
                    <?php foreach ($poll->getAnswers() as $index => $answer):
                        ?>
                        <input type="radio" v-model="answer" name="answer"
                               value="<?= $answersIDs[$index] ?>">
                        <label><?= $answer ?></label>
                    <?php endforeach; ?>
                </div>

                <input type="submit" class="submit-btn" @click="checkForm">
            </div>
            <div v-else class="alert alert-green">
                Вы проголосовали в данном опросе!
            </div>

        <?php else: ?>
            <div class="alert alert-green">
                Вы уже проголосовали в данном опросе!
            </div>
        <?php endif; ?>


    </form>


    <h1>Результаты</h1>


    <table v-if="resultsLength" class="my-table results-table">
        <tr>
            <th>Name</th>
            <?php foreach ($poll->getAnswers() as $index => $answer) :
                ?>
                <th><?= $answer ?></th>
            <?php endforeach; ?>
        </tr>
        <tr v-for="result in results">
            <td>{{result.username}}</td>
            <?php foreach ($poll->getAnswers() as $index => $answer):
                ?>
                <td v-if="result.answer==='<?= $answer ?>'">x</td>
                <td v-else></td>
            <?php endforeach; ?>
        </tr>
    </table>
    <p v-else>
        Ещё никто не проголовал в данном опросе!
    </p>

</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>


<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="../resources/js/poll.js"></script>



