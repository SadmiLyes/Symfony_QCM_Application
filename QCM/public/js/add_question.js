let $id = '';
$(document).ready(function () {
    if ($('#main').is(':empty')){
        alert()
    }
    $('#saveQuestion').submit(function (e) {
        e.preventDefault();
        const $link = $(e.currentTarget);
        const formSerialize = $(this).serialize();
        $.ajax({
            method: 'POST',
            url: $link.attr('href'),
            data: formSerialize
        }).done(function (data) {
            $id = data.Id;
            $('#main').append(questionCard(data.Id, data));
            $('#saveQuestion').hide();
            $("#suggestionForm").toggleClass('d-none', '');
            $(`#suggestion_question`).val(data.Id);
            $('.question_title').text('Add suggestions :');
        })
    });
    $("#suggestionForm").submit(submitSuggestion)
});

function nextQuestionEventHandler() {
    $('#suggestionForm').addClass('d-none');
    $('#saveQuestion').show();
    $('#question_enunciate').val('');
    $('#question_isMultiple').prop('checked', false);
    $('.question_title').text('Add new question :');
}

function submitSuggestion(e) {
    e.preventDefault();
    const formSerialize = $('#suggestionForm').serialize();
    const url = $('#suggestionRoute').val();
    $.ajax({
        method: 'POST',
        url: url,
        data: formSerialize
    }).done(function (data) {
        $('#suggestion_content').val('');
        $('#suggestion_answer').prop('checked', false);
        $(`.showSuggestion${$id}`).append(suggestion(data));
        $('#createSession').toggleClass('d-none', '');
        if ($('#nextQuestionBox').length == 0) {
            $('#controlPanel').append(nextQuesiton(nextQuestionEventHandler));
        }
    })
}

function question(question) {
    return ("<div class=\"card\">\n" +
        "                            <div class=\"card-body bg-light\">\n" +
        "                                <h5 class=\"card-title\">The question</h5>\n" +
        "                                <p class=\"card-text\">" + question.Enunciate + "</p>\n" +
        "                                " + isMultiple(question.isMultiple) +
        "                                <a href=\"#\" class=\"btn btn-warning mr-auto\">Edit</a>\n" +
        "                            </div>\n" +
        "                        </div>");
}

function isMultiple(bool) {
    if (bool) {
        return "<div class=\"text-right\"><a href=\"#\" class=\"alert-link text-center\">Multiple</a></div>";
    }
    return "<div class=\"text-right\"><a href=\"#\" class=\"info-link text-center\">Single</a></div>";
}

function suggestion(suggestion) {
    return $.parseHTML(
        "<div class=\"col-lg-12 row mx-auto\">\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                    <div class=\"alert alert-info\" role=\"alert\">\n" +
        "                                        " + suggestion.content + "\n" +
        "                                    </div>\n" +
        "\n" +
        "                            </div>\n" +
        "\n" +
        "                            <div class=\"col-lg-3\">\n" +
        "                                " + isTrue(suggestion.answer) +
        "                            </div>\n" +
        "\n" +
        "                            <div class=\"col-lg-3\">\n" +
        "                                <div class=\"alert alert-warning text-center\">\n" +
        "                                    <a href=\"#\" class=\"alert-link\">Edit</a>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                        </div>");
}

function isTrue(bool) {
    if (bool) {
        return "<div class=\"alert alert-success\" role=\"alert\">The answer is true</div>\n";
    }
    return "<div class=\"alert alert-danger\" role=\"alert\">The answer is false</div>\n";
}

function questionCard(num, dataQuestion) {
    return $.parseHTML(
        "<div class=\"card mt-4\">\n" +
        "            <div class=\"card-body\">\n" +
        "                <h3 class=\"card-title text-center text-secondary\">Question :</h3>\n" +
        "                <hr>\n" +
        "                <div class=\"showQuestion" + num + "\">" +
        "               " + question(dataQuestion) +
        "                </div>\n" +
        "                <hr>\n" +
        "                <div class=\"showSuggestion" + num + "\" class=\"\"></div>\n" +
        "            </div>\n" +
        "        </div>"
    );
}

function nextQuesiton(clickEventHandler) {
    return $('<div>', {
        id: 'nextQuestionBox'
    }).append(
        $('<a>', {
            class: 'btn text-white btn-info m-3',
            id: 'nextQuestionBox',
            text: 'Next question',
            click: clickEventHandler
        })
    );
}

