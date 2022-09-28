<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Prestação de serviço</title>

    <style>
        body {
            font-size: 12pt;
            font-family: sans-serif;
        }

        @page {
            margin: 0.9in;
        }

        h1, h2, h3 {
            margin: 0;
        }

        h1 {
            margin-bottom: 36px;
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }

        h2 {
            margin-bottom: 24px;
            margin-left: 48px;
            font-size: 12pt;
            font-weight: bold;
        }

        h3 {
            margin-bottom: 24px;
            font-size: 12pt;
            font-weight: bold;
            font-style: italic;
        }

        p, ol, ul {
            text-align: justify;
        }

        p {
            margin-bottom: 6px;
        }

        ol, ul {
            padding: 0;
        }

        li {
            margin-bottom: 6px;
            padding: 0 0 0 48px;
        }

        ol.lst-kix_list_7-0 {
            list-style-type: none
        }

        ol.lst-kix_list_38-6 {
            list-style-type: none
        }

        ol.lst-kix_list_38-5 {
            list-style-type: none
        }

        ol.lst-kix_list_38-8 {
            list-style-type: none
        }

        ol.lst-kix_list_38-7 {
            list-style-type: none
        }

        ol.lst-kix_list_38-2 {
            list-style-type: none
        }

        ol.lst-kix_list_38-1 {
            list-style-type: none
        }

        ol.lst-kix_list_38-4 {
            list-style-type: none
        }

        ol.lst-kix_list_30-0.start {
            counter-reset: lst-ctn-kix_list_30-0 0
        }

        ol.lst-kix_list_38-3 {
            list-style-type: none
        }

        ol.lst-kix_list_38-0 {
            list-style-type: none
        }

        ol.lst-kix_list_13-4.start {
            counter-reset: lst-ctn-kix_list_13-4 0
        }

        ul.lst-kix_list_9-3 {
            list-style-type: none
        }

        ul.lst-kix_list_9-4 {
            list-style-type: none
        }

        ol.lst-kix_list_40-3.start {
            counter-reset: lst-ctn-kix_list_40-3 0
        }

        .lst-kix_list_42-8 > li:before {
            content: "" counter(lst-ctn-kix_list_42-8, lower-roman) ". "
        }

        ul.lst-kix_list_9-1 {
            list-style-type: none
        }

        ul.lst-kix_list_9-2 {
            list-style-type: none
        }

        ul.lst-kix_list_9-7 {
            list-style-type: none
        }

        .lst-kix_list_13-0 > li {
            counter-increment: lst-ctn-kix_list_13-0
        }

        ul.lst-kix_list_9-8 {
            list-style-type: none
        }

        ol.lst-kix_list_20-2.start {
            counter-reset: lst-ctn-kix_list_20-2 0
        }

        ul.lst-kix_list_9-5 {
            list-style-type: none
        }

        .lst-kix_list_5-0 > li {
            counter-increment: lst-ctn-kix_list_5-0
        }

        ul.lst-kix_list_9-6 {
            list-style-type: none
        }

        ol.lst-kix_list_37-2.start {
            counter-reset: lst-ctn-kix_list_37-2 0
        }

        ol.lst-kix_list_7-5 {
            list-style-type: none
        }

        ol.lst-kix_list_7-6 {
            list-style-type: none
        }

        ol.lst-kix_list_7-7 {
            list-style-type: none
        }

        ol.lst-kix_list_7-8 {
            list-style-type: none
        }

        ol.lst-kix_list_7-1 {
            list-style-type: none
        }

        ol.lst-kix_list_7-2 {
            list-style-type: none
        }

        ul.lst-kix_list_9-0 {
            list-style-type: none
        }

        ol.lst-kix_list_7-3 {
            list-style-type: none
        }

        ol.lst-kix_list_7-4 {
            list-style-type: none
        }

        .lst-kix_list_42-0 > li:before {
            content: "(" counter(lst-ctn-kix_list_42-0, upper-roman) ") "
        }

        .lst-kix_list_42-1 > li:before {
            content: "" counter(lst-ctn-kix_list_42-1, lower-latin) ". "
        }

        .lst-kix_list_42-2 > li:before {
            content: "" counter(lst-ctn-kix_list_42-2, lower-roman) ". "
        }

        .lst-kix_list_40-1 > li {
            counter-increment: lst-ctn-kix_list_40-1
        }

        ol.lst-kix_list_5-3.start {
            counter-reset: lst-ctn-kix_list_5-3 0
        }

        .lst-kix_list_38-6 > li {
            counter-increment: lst-ctn-kix_list_38-6
        }

        .lst-kix_list_4-3 > li {
            counter-increment: lst-ctn-kix_list_4-3
        }

        .lst-kix_list_42-7 > li:before {
            content: "" counter(lst-ctn-kix_list_42-7, lower-latin) ". "
        }

        .lst-kix_list_35-7 > li {
            counter-increment: lst-ctn-kix_list_35-7
        }

        .lst-kix_list_42-6 > li:before {
            content: "" counter(lst-ctn-kix_list_42-6, decimal) ". "
        }

        .lst-kix_list_42-4 > li:before {
            content: "" counter(lst-ctn-kix_list_42-4, lower-latin) ". "
        }

        .lst-kix_list_42-5 > li:before {
            content: "" counter(lst-ctn-kix_list_42-5, lower-roman) ". "
        }

        .lst-kix_list_42-3 > li:before {
            content: "" counter(lst-ctn-kix_list_42-3, decimal) ". "
        }

        .lst-kix_list_7-2 > li {
            counter-increment: lst-ctn-kix_list_7-2
        }

        ol.lst-kix_list_36-5.start {
            counter-reset: lst-ctn-kix_list_36-5 0
        }

        .lst-kix_list_24-7 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_27-0 {
            list-style-type: none
        }

        ul.lst-kix_list_27-1 {
            list-style-type: none
        }

        .lst-kix_list_24-8 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_27-2 {
            list-style-type: none
        }

        ol.lst-kix_list_40-8.start {
            counter-reset: lst-ctn-kix_list_40-8 0
        }

        .lst-kix_list_24-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_20-7.start {
            counter-reset: lst-ctn-kix_list_20-7 0
        }

        .lst-kix_list_24-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_24-4 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_27-3 {
            list-style-type: none
        }

        .lst-kix_list_24-5 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_27-4 {
            list-style-type: none
        }

        ul.lst-kix_list_27-5 {
            list-style-type: none
        }

        ul.lst-kix_list_27-6 {
            list-style-type: none
        }

        ul.lst-kix_list_27-7 {
            list-style-type: none
        }

        ul.lst-kix_list_27-8 {
            list-style-type: none
        }

        .lst-kix_list_24-6 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_14-1.start {
            counter-reset: lst-ctn-kix_list_14-1 0
        }

        .lst-kix_list_23-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_6-5 > li {
            counter-increment: lst-ctn-kix_list_6-5
        }

        .lst-kix_list_23-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_23-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_23-2 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_16-2 {
            list-style-type: none
        }

        ul.lst-kix_list_16-1 {
            list-style-type: none
        }

        ul.lst-kix_list_16-0 {
            list-style-type: none
        }

        .lst-kix_list_23-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_23-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_23-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_24-1 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_16-8 {
            list-style-type: none
        }

        ul.lst-kix_list_16-7 {
            list-style-type: none
        }

        ul.lst-kix_list_16-6 {
            list-style-type: none
        }

        ul.lst-kix_list_16-5 {
            list-style-type: none
        }

        .lst-kix_list_24-0 > li:before {
            content: "\0025cf   "
        }

        ul.lst-kix_list_16-4 {
            list-style-type: none
        }

        ul.lst-kix_list_16-3 {
            list-style-type: none
        }

        .lst-kix_list_23-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_23-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_31-2.start {
            counter-reset: lst-ctn-kix_list_31-2 0
        }

        .lst-kix_list_22-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_22-6 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_36-0.start {
            counter-reset: lst-ctn-kix_list_36-0 0
        }

        .lst-kix_list_22-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_22-8 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_4-6.start {
            counter-reset: lst-ctn-kix_list_4-6 0
        }

        ol.lst-kix_list_39-5.start {
            counter-reset: lst-ctn-kix_list_39-5 0
        }

        .lst-kix_list_5-7 > li {
            counter-increment: lst-ctn-kix_list_5-7
        }

        .lst-kix_list_22-4 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_25-5.start {
            counter-reset: lst-ctn-kix_list_25-5 0
        }

        .lst-kix_list_41-7 > li:before {
            content: "" counter(lst-ctn-kix_list_41-7, lower-latin) ". "
        }

        .lst-kix_list_25-5 > li:before {
            content: "" counter(lst-ctn-kix_list_25-5, lower-roman) ". "
        }

        .lst-kix_list_25-7 > li:before {
            content: "" counter(lst-ctn-kix_list_25-7, lower-latin) ". "
        }

        ol.lst-kix_list_33-0.start {
            counter-reset: lst-ctn-kix_list_33-0 0
        }

        .lst-kix_list_6-4 > li {
            counter-increment: lst-ctn-kix_list_6-4
        }

        .lst-kix_list_41-1 > li:before {
            content: "" counter(lst-ctn-kix_list_41-1, lower-latin) ". "
        }

        ul.lst-kix_list_29-0 {
            list-style-type: none
        }

        .lst-kix_list_40-7 > li:before {
            content: "" counter(lst-ctn-kix_list_40-7, lower-latin) ". "
        }

        .lst-kix_list_40-5 > li:before {
            content: "" counter(lst-ctn-kix_list_40-5, lower-roman) ". "
        }

        ol.lst-kix_list_15-2.start {
            counter-reset: lst-ctn-kix_list_15-2 0
        }

        ol.lst-kix_list_42-1.start {
            counter-reset: lst-ctn-kix_list_42-1 0
        }

        .lst-kix_list_41-5 > li:before {
            content: "" counter(lst-ctn-kix_list_41-5, lower-roman) ". "
        }

        ol.lst-kix_list_37-7.start {
            counter-reset: lst-ctn-kix_list_37-7 0
        }

        ol.lst-kix_list_7-6.start {
            counter-reset: lst-ctn-kix_list_7-6 0
        }

        ul.lst-kix_list_29-1 {
            list-style-type: none
        }

        ul.lst-kix_list_29-2 {
            list-style-type: none
        }

        ul.lst-kix_list_29-3 {
            list-style-type: none
        }

        ul.lst-kix_list_29-4 {
            list-style-type: none
        }

        ul.lst-kix_list_29-5 {
            list-style-type: none
        }

        ul.lst-kix_list_29-6 {
            list-style-type: none
        }

        .lst-kix_list_41-3 > li:before {
            content: "" counter(lst-ctn-kix_list_41-3, decimal) ". "
        }

        ul.lst-kix_list_29-7 {
            list-style-type: none
        }

        ul.lst-kix_list_29-8 {
            list-style-type: none
        }

        ol.lst-kix_list_15-3.start {
            counter-reset: lst-ctn-kix_list_15-3 0
        }

        ul.lst-kix_list_18-0 {
            list-style-type: none
        }

        ol.lst-kix_list_5-8.start {
            counter-reset: lst-ctn-kix_list_5-8 0
        }

        .lst-kix_list_40-3 > li:before {
            content: "" counter(lst-ctn-kix_list_40-3, decimal) ". "
        }

        ul.lst-kix_list_18-8 {
            list-style-type: none
        }

        ul.lst-kix_list_18-7 {
            list-style-type: none
        }

        ul.lst-kix_list_18-6 {
            list-style-type: none
        }

        ol.lst-kix_list_12-2.start {
            counter-reset: lst-ctn-kix_list_12-2 0
        }

        ul.lst-kix_list_18-5 {
            list-style-type: none
        }

        ul.lst-kix_list_18-4 {
            list-style-type: none
        }

        ul.lst-kix_list_18-3 {
            list-style-type: none
        }

        ul.lst-kix_list_18-2 {
            list-style-type: none
        }

        ol.lst-kix_list_6-0.start {
            counter-reset: lst-ctn-kix_list_6-0 0
        }

        ul.lst-kix_list_18-1 {
            list-style-type: none
        }

        .lst-kix_list_40-1 > li:before {
            content: "" counter(lst-ctn-kix_list_40-1, lower-latin) ". "
        }

        .lst-kix_list_4-2 > li {
            counter-increment: lst-ctn-kix_list_4-2
        }

        .lst-kix_list_42-2 > li {
            counter-increment: lst-ctn-kix_list_42-2
        }

        ol.lst-kix_list_38-3.start {
            counter-reset: lst-ctn-kix_list_38-3 0
        }

        .lst-kix_list_5-1 > li {
            counter-increment: lst-ctn-kix_list_5-1
        }

        ol.lst-kix_list_19-0.start {
            counter-reset: lst-ctn-kix_list_19-0 0
        }

        .lst-kix_list_7-1 > li {
            counter-increment: lst-ctn-kix_list_7-1
        }

        .lst-kix_list_38-5 > li {
            counter-increment: lst-ctn-kix_list_38-5
        }

        ol.lst-kix_list_25-6.start {
            counter-reset: lst-ctn-kix_list_25-6 0
        }

        .lst-kix_list_21-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_26-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_26-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_21-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_26-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_13-1 > li {
            counter-increment: lst-ctn-kix_list_13-1
        }

        .lst-kix_list_21-1 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_15-8.start {
            counter-reset: lst-ctn-kix_list_15-8 0
        }

        .lst-kix_list_26-4 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_36-1.start {
            counter-reset: lst-ctn-kix_list_36-1 0
        }

        .lst-kix_list_42-4 > li {
            counter-increment: lst-ctn-kix_list_42-4
        }

        .lst-kix_list_21-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_21-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_26-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_31-4 > li {
            counter-increment: lst-ctn-kix_list_31-4
        }

        ul.lst-kix_list_23-0 {
            list-style-type: none
        }

        ul.lst-kix_list_23-1 {
            list-style-type: none
        }

        ol.lst-kix_list_7-2.start {
            counter-reset: lst-ctn-kix_list_7-2 0
        }

        ul.lst-kix_list_23-2 {
            list-style-type: none
        }

        ul.lst-kix_list_23-3 {
            list-style-type: none
        }

        ul.lst-kix_list_23-4 {
            list-style-type: none
        }

        .lst-kix_list_31-2 > li {
            counter-increment: lst-ctn-kix_list_31-2
        }

        ul.lst-kix_list_23-5 {
            list-style-type: none
        }

        ol.lst-kix_list_38-8.start {
            counter-reset: lst-ctn-kix_list_38-8 0
        }

        ul.lst-kix_list_23-6 {
            list-style-type: none
        }

        ol.lst-kix_list_19-5.start {
            counter-reset: lst-ctn-kix_list_19-5 0
        }

        ol.lst-kix_list_12-5 {
            list-style-type: none
        }

        ol.lst-kix_list_12-6 {
            list-style-type: none
        }

        ol.lst-kix_list_12-7 {
            list-style-type: none
        }

        ol.lst-kix_list_12-8 {
            list-style-type: none
        }

        ol.lst-kix_list_12-1 {
            list-style-type: none
        }

        ol.lst-kix_list_12-2 {
            list-style-type: none
        }

        ol.lst-kix_list_12-3 {
            list-style-type: none
        }

        .lst-kix_list_35-8 > li {
            counter-increment: lst-ctn-kix_list_35-8
        }

        ol.lst-kix_list_12-4 {
            list-style-type: none
        }

        ol.lst-kix_list_39-6.start {
            counter-reset: lst-ctn-kix_list_39-6 0
        }

        ol.lst-kix_list_12-0 {
            list-style-type: none
        }

        .lst-kix_list_25-1 > li:before {
            content: "" counter(lst-ctn-kix_list_25-1, lower-latin) ". "
        }

        ul.lst-kix_list_23-7 {
            list-style-type: none
        }

        .lst-kix_list_25-0 > li:before {
            content: "" counter(lst-ctn-kix_list_25-0, decimal) ") "
        }

        ul.lst-kix_list_23-8 {
            list-style-type: none
        }

        ol.lst-kix_list_31-1.start {
            counter-reset: lst-ctn-kix_list_31-1 0
        }

        ol.lst-kix_list_7-1.start {
            counter-reset: lst-ctn-kix_list_7-1 0
        }

        .lst-kix_list_39-0 > li:before {
            content: "" counter(lst-ctn-kix_list_39-0, lower-latin) ") "
        }

        .lst-kix_list_39-1 > li:before {
            content: "" counter(lst-ctn-kix_list_39-1, lower-latin) ". "
        }

        ol.lst-kix_list_40-7.start {
            counter-reset: lst-ctn-kix_list_40-7 0
        }

        .lst-kix_list_37-0 > li {
            counter-increment: lst-ctn-kix_list_37-0
        }

        ol.lst-kix_list_20-6.start {
            counter-reset: lst-ctn-kix_list_20-6 0
        }

        .lst-kix_list_13-8 > li {
            counter-increment: lst-ctn-kix_list_13-8
        }

        .lst-kix_list_38-7 > li {
            counter-increment: lst-ctn-kix_list_38-7
        }

        ol.lst-kix_list_4-7.start {
            counter-reset: lst-ctn-kix_list_4-7 0
        }

        ol.lst-kix_list_5-0 {
            list-style-type: none
        }

        ol.lst-kix_list_5-1 {
            list-style-type: none
        }

        ol.lst-kix_list_5-2 {
            list-style-type: none
        }

        .lst-kix_list_40-8 > li {
            counter-increment: lst-ctn-kix_list_40-8
        }

        .lst-kix_list_22-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_36-8 {
            list-style-type: none
        }

        ol.lst-kix_list_36-7 {
            list-style-type: none
        }

        ol.lst-kix_list_36-4 {
            list-style-type: none
        }

        ol.lst-kix_list_36-3 {
            list-style-type: none
        }

        ol.lst-kix_list_36-6 {
            list-style-type: none
        }

        ol.lst-kix_list_36-5 {
            list-style-type: none
        }

        .lst-kix_list_22-1 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_36-0 {
            list-style-type: none
        }

        .lst-kix_list_27-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_20-2 > li {
            counter-increment: lst-ctn-kix_list_20-2
        }

        .lst-kix_list_6-6 > li {
            counter-increment: lst-ctn-kix_list_6-6
        }

        ol.lst-kix_list_36-2 {
            list-style-type: none
        }

        ol.lst-kix_list_15-7.start {
            counter-reset: lst-ctn-kix_list_15-7 0
        }

        ol.lst-kix_list_36-1 {
            list-style-type: none
        }

        .lst-kix_list_13-6 > li {
            counter-increment: lst-ctn-kix_list_13-6
        }

        ol.lst-kix_list_14-6.start {
            counter-reset: lst-ctn-kix_list_14-6 0
        }

        .lst-kix_list_39-4 > li:before {
            content: "" counter(lst-ctn-kix_list_39-4, lower-latin) ". "
        }

        .lst-kix_list_39-8 > li:before {
            content: "" counter(lst-ctn-kix_list_39-8, lower-roman) ". "
        }

        ol.lst-kix_list_5-7 {
            list-style-type: none
        }

        ol.lst-kix_list_5-8 {
            list-style-type: none
        }

        ol.lst-kix_list_5-3 {
            list-style-type: none
        }

        .lst-kix_list_19-6 > li {
            counter-increment: lst-ctn-kix_list_19-6
        }

        ol.lst-kix_list_5-4 {
            list-style-type: none
        }

        .lst-kix_list_27-0 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_5-5 {
            list-style-type: none
        }

        ol.lst-kix_list_5-6 {
            list-style-type: none
        }

        .lst-kix_list_20-4 > li {
            counter-increment: lst-ctn-kix_list_20-4
        }

        .lst-kix_list_5-8 > li {
            counter-increment: lst-ctn-kix_list_5-8
        }

        .lst-kix_list_41-6 > li {
            counter-increment: lst-ctn-kix_list_41-6
        }

        ol.lst-kix_list_19-4.start {
            counter-reset: lst-ctn-kix_list_19-4 0
        }

        .lst-kix_list_38-0 > li {
            counter-increment: lst-ctn-kix_list_38-0
        }

        .lst-kix_list_32-0 > li {
            counter-increment: lst-ctn-kix_list_32-0
        }

        ol.lst-kix_list_20-1.start {
            counter-reset: lst-ctn-kix_list_20-1 0
        }

        .lst-kix_list_25-4 > li:before {
            content: "" counter(lst-ctn-kix_list_25-4, lower-latin) ". "
        }

        .lst-kix_list_19-4 > li {
            counter-increment: lst-ctn-kix_list_19-4
        }

        .lst-kix_list_35-1 > li {
            counter-increment: lst-ctn-kix_list_35-1
        }

        .lst-kix_list_25-8 > li:before {
            content: "" counter(lst-ctn-kix_list_25-8, lower-roman) ". "
        }

        ol.lst-kix_list_38-4.start {
            counter-reset: lst-ctn-kix_list_38-4 0
        }

        ol.lst-kix_list_25-1.start {
            counter-reset: lst-ctn-kix_list_25-1 0
        }

        ol.lst-kix_list_14-7 {
            list-style-type: none
        }

        ol.lst-kix_list_14-8 {
            list-style-type: none
        }

        .lst-kix_list_37-2 > li {
            counter-increment: lst-ctn-kix_list_37-2
        }

        ol.lst-kix_list_14-3 {
            list-style-type: none
        }

        ol.lst-kix_list_14-4 {
            list-style-type: none
        }

        ol.lst-kix_list_14-5 {
            list-style-type: none
        }

        ol.lst-kix_list_14-6 {
            list-style-type: none
        }

        .lst-kix_list_15-2 > li {
            counter-increment: lst-ctn-kix_list_15-2
        }

        ol.lst-kix_list_14-0 {
            list-style-type: none
        }

        ol.lst-kix_list_14-1 {
            list-style-type: none
        }

        .lst-kix_list_40-6 > li:before {
            content: "" counter(lst-ctn-kix_list_40-6, decimal) ". "
        }

        ol.lst-kix_list_14-2 {
            list-style-type: none
        }

        .lst-kix_list_41-6 > li:before {
            content: "" counter(lst-ctn-kix_list_41-6, decimal) ". "
        }

        .lst-kix_list_20-5 > li:before {
            content: "" counter(lst-ctn-kix_list_20-5, lower-roman) ". "
        }

        .lst-kix_list_28-8 > li:before {
            content: "" counter(lst-ctn-kix_list_28-8, lower-roman) ". "
        }

        .lst-kix_list_41-2 > li:before {
            content: "" counter(lst-ctn-kix_list_41-2, lower-roman) ". "
        }

        .lst-kix_list_20-1 > li:before {
            content: "" counter(lst-ctn-kix_list_20-1, lower-latin) ". "
        }

        .lst-kix_list_12-3 > li {
            counter-increment: lst-ctn-kix_list_12-3
        }

        .lst-kix_list_28-4 > li:before {
            content: "" counter(lst-ctn-kix_list_28-4, lower-latin) ". "
        }

        .lst-kix_list_39-3 > li {
            counter-increment: lst-ctn-kix_list_39-3
        }

        .lst-kix_list_28-3 > li {
            counter-increment: lst-ctn-kix_list_28-3
        }

        ol.lst-kix_list_25-0.start {
            counter-reset: lst-ctn-kix_list_25-0 0
        }

        ol.lst-kix_list_25-8 {
            list-style-type: none
        }

        ol.lst-kix_list_25-7 {
            list-style-type: none
        }

        .lst-kix_list_35-6 > li {
            counter-increment: lst-ctn-kix_list_35-6
        }

        ol.lst-kix_list_25-4 {
            list-style-type: none
        }

        ol.lst-kix_list_25-3 {
            list-style-type: none
        }

        ol.lst-kix_list_13-0.start {
            counter-reset: lst-ctn-kix_list_13-0 0
        }

        .lst-kix_list_14-4 > li {
            counter-increment: lst-ctn-kix_list_14-4
        }

        ol.lst-kix_list_25-6 {
            list-style-type: none
        }

        ol.lst-kix_list_25-5 {
            list-style-type: none
        }

        ol.lst-kix_list_25-0 {
            list-style-type: none
        }

        ol.lst-kix_list_25-2 {
            list-style-type: none
        }

        ol.lst-kix_list_25-1 {
            list-style-type: none
        }

        .lst-kix_list_25-4 > li {
            counter-increment: lst-ctn-kix_list_25-4
        }

        .lst-kix_list_11-5 > li {
            counter-increment: lst-ctn-kix_list_11-5
        }

        ol.lst-kix_list_14-5.start {
            counter-reset: lst-ctn-kix_list_14-5 0
        }

        .lst-kix_list_28-0 > li:before {
            content: "(" counter(lst-ctn-kix_list_28-0, upper-roman) ") "
        }

        .lst-kix_list_27-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_40-2 > li:before {
            content: "" counter(lst-ctn-kix_list_40-2, lower-roman) ". "
        }

        ol.lst-kix_list_20-3.start {
            counter-reset: lst-ctn-kix_list_20-3 0
        }

        ol.lst-kix_list_37-1.start {
            counter-reset: lst-ctn-kix_list_37-1 0
        }

        .lst-kix_list_36-4 > li {
            counter-increment: lst-ctn-kix_list_36-4
        }

        .lst-kix_list_4-1 > li {
            counter-increment: lst-ctn-kix_list_4-1
        }

        .lst-kix_list_19-1 > li:before {
            content: "" counter(lst-ctn-kix_list_19-1, lower-latin) ". "
        }

        ul.lst-kix_list_1-0 {
            list-style-type: none
        }

        ol.lst-kix_list_41-1.start {
            counter-reset: lst-ctn-kix_list_41-1 0
        }

        .lst-kix_list_19-4 > li:before {
            content: "" counter(lst-ctn-kix_list_19-4, lower-latin) ". "
        }

        ol.lst-kix_list_37-8.start {
            counter-reset: lst-ctn-kix_list_37-8 0
        }

        .lst-kix_list_31-5 > li {
            counter-increment: lst-ctn-kix_list_31-5
        }

        .lst-kix_list_19-3 > li:before {
            content: "" counter(lst-ctn-kix_list_19-3, decimal) ". "
        }

        ol.lst-kix_list_38-0.start {
            counter-reset: lst-ctn-kix_list_38-0 0
        }

        .lst-kix_list_15-0 > li {
            counter-increment: lst-ctn-kix_list_15-0
        }

        ol.lst-kix_list_6-6.start {
            counter-reset: lst-ctn-kix_list_6-6 0
        }

        .lst-kix_list_39-5 > li {
            counter-increment: lst-ctn-kix_list_39-5
        }

        .lst-kix_list_11-0 > li {
            counter-increment: lst-ctn-kix_list_11-0
        }

        ul.lst-kix_list_1-3 {
            list-style-type: none
        }

        ul.lst-kix_list_1-4 {
            list-style-type: none
        }

        ul.lst-kix_list_1-1 {
            list-style-type: none
        }

        ul.lst-kix_list_1-2 {
            list-style-type: none
        }

        ul.lst-kix_list_1-7 {
            list-style-type: none
        }

        ul.lst-kix_list_1-8 {
            list-style-type: none
        }

        ul.lst-kix_list_1-5 {
            list-style-type: none
        }

        ul.lst-kix_list_1-6 {
            list-style-type: none
        }

        ul.lst-kix_list_32-1 {
            list-style-type: none
        }

        ul.lst-kix_list_32-2 {
            list-style-type: none
        }

        ul.lst-kix_list_32-3 {
            list-style-type: none
        }

        ul.lst-kix_list_32-4 {
            list-style-type: none
        }

        ul.lst-kix_list_32-5 {
            list-style-type: none
        }

        ul.lst-kix_list_32-6 {
            list-style-type: none
        }

        ul.lst-kix_list_32-7 {
            list-style-type: none
        }

        ul.lst-kix_list_32-8 {
            list-style-type: none
        }

        ol.lst-kix_list_4-5.start {
            counter-reset: lst-ctn-kix_list_4-5 0
        }

        .lst-kix_list_37-0 > li:before {
            content: "" counter(lst-ctn-kix_list_37-0, lower-latin) ") "
        }

        .lst-kix_list_41-0 > li {
            counter-increment: lst-ctn-kix_list_41-0
        }

        ol.lst-kix_list_11-2.start {
            counter-reset: lst-ctn-kix_list_11-2 0
        }

        .lst-kix_list_42-1 > li {
            counter-increment: lst-ctn-kix_list_42-1
        }

        .lst-kix_list_5-2 > li {
            counter-increment: lst-ctn-kix_list_5-2
        }

        .lst-kix_list_37-7 > li {
            counter-increment: lst-ctn-kix_list_37-7
        }

        .lst-kix_list_19-6 > li:before {
            content: "" counter(lst-ctn-kix_list_19-6, decimal) ". "
        }

        .lst-kix_list_37-8 > li:before {
            content: "" counter(lst-ctn-kix_list_37-8, lower-roman) ". "
        }

        ol.lst-kix_list_41-6.start {
            counter-reset: lst-ctn-kix_list_41-6 0
        }

        .lst-kix_list_37-6 > li:before {
            content: "" counter(lst-ctn-kix_list_37-6, decimal) ". "
        }

        .lst-kix_list_42-5 > li {
            counter-increment: lst-ctn-kix_list_42-5
        }

        .lst-kix_list_36-2 > li {
            counter-increment: lst-ctn-kix_list_36-2
        }

        .lst-kix_list_28-5 > li {
            counter-increment: lst-ctn-kix_list_28-5
        }

        ol.lst-kix_list_31-8 {
            list-style-type: none
        }

        .lst-kix_list_20-5 > li {
            counter-increment: lst-ctn-kix_list_20-5
        }

        ol.lst-kix_list_31-5 {
            list-style-type: none
        }

        ol.lst-kix_list_31-4 {
            list-style-type: none
        }

        ol.lst-kix_list_31-7 {
            list-style-type: none
        }

        ol.lst-kix_list_35-0.start {
            counter-reset: lst-ctn-kix_list_35-0 0
        }

        ol.lst-kix_list_31-6 {
            list-style-type: none
        }

        ol.lst-kix_list_37-3.start {
            counter-reset: lst-ctn-kix_list_37-3 0
        }

        ol.lst-kix_list_31-1 {
            list-style-type: none
        }

        ol.lst-kix_list_31-0 {
            list-style-type: none
        }

        ol.lst-kix_list_31-3 {
            list-style-type: none
        }

        .lst-kix_list_37-1 > li:before {
            content: "" counter(lst-ctn-kix_list_37-1, lower-latin) ". "
        }

        ol.lst-kix_list_31-2 {
            list-style-type: none
        }

        .lst-kix_list_37-3 > li:before {
            content: "" counter(lst-ctn-kix_list_37-3, decimal) ". "
        }

        ol.lst-kix_list_35-7.start {
            counter-reset: lst-ctn-kix_list_35-7 0
        }

        .lst-kix_list_37-3 > li {
            counter-increment: lst-ctn-kix_list_37-3
        }

        .lst-kix_list_18-0 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_13-3.start {
            counter-reset: lst-ctn-kix_list_13-3 0
        }

        .lst-kix_list_38-7 > li:before {
            content: "" counter(lst-ctn-kix_list_38-7, lower-latin) ". "
        }

        .lst-kix_list_18-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_42-8 {
            list-style-type: none
        }

        ol.lst-kix_list_4-0.start {
            counter-reset: lst-ctn-kix_list_4-0 0
        }

        ol.lst-kix_list_42-6 {
            list-style-type: none
        }

        ol.lst-kix_list_42-7 {
            list-style-type: none
        }

        ol.lst-kix_list_42-4 {
            list-style-type: none
        }

        ol.lst-kix_list_42-5 {
            list-style-type: none
        }

        ol.lst-kix_list_42-2 {
            list-style-type: none
        }

        ol.lst-kix_list_42-3 {
            list-style-type: none
        }

        ol.lst-kix_list_42-0 {
            list-style-type: none
        }

        ol.lst-kix_list_42-1 {
            list-style-type: none
        }

        .lst-kix_list_38-2 > li:before {
            content: "" counter(lst-ctn-kix_list_38-2, lower-roman) ". "
        }

        .lst-kix_list_38-4 > li:before {
            content: "" counter(lst-ctn-kix_list_38-4, lower-latin) ". "
        }

        ol.lst-kix_list_11-7.start {
            counter-reset: lst-ctn-kix_list_11-7 0
        }

        ol.lst-kix_list_14-2.start {
            counter-reset: lst-ctn-kix_list_14-2 0
        }

        .lst-kix_list_41-4 > li {
            counter-increment: lst-ctn-kix_list_41-4
        }

        .lst-kix_list_38-4 > li {
            counter-increment: lst-ctn-kix_list_38-4
        }

        .lst-kix_list_38-5 > li:before {
            content: "" counter(lst-ctn-kix_list_38-5, lower-roman) ". "
        }

        .lst-kix_list_25-2 > li {
            counter-increment: lst-ctn-kix_list_25-2
        }

        .lst-kix_list_27-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_27-3 > li:before {
            content: "\0025cf   "
        }

        ul.lst-kix_list_3-7 {
            list-style-type: none
        }

        ul.lst-kix_list_3-8 {
            list-style-type: none
        }

        ol.lst-kix_list_41-8.start {
            counter-reset: lst-ctn-kix_list_41-8 0
        }

        .lst-kix_list_18-8 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_3-1 {
            list-style-type: none
        }

        ul.lst-kix_list_3-2 {
            list-style-type: none
        }

        ul.lst-kix_list_3-0 {
            list-style-type: none
        }

        ol.lst-kix_list_4-3.start {
            counter-reset: lst-ctn-kix_list_4-3 0
        }

        ul.lst-kix_list_3-5 {
            list-style-type: none
        }

        ul.lst-kix_list_3-6 {
            list-style-type: none
        }

        ul.lst-kix_list_3-3 {
            list-style-type: none
        }

        ul.lst-kix_list_3-4 {
            list-style-type: none
        }

        .lst-kix_list_10-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_7-8 > li {
            counter-increment: lst-ctn-kix_list_7-8
        }

        ul.lst-kix_list_34-0 {
            list-style-type: none
        }

        .lst-kix_list_20-1 > li {
            counter-increment: lst-ctn-kix_list_20-1
        }

        ul.lst-kix_list_34-1 {
            list-style-type: none
        }

        .lst-kix_list_36-4 > li:before {
            content: "" counter(lst-ctn-kix_list_36-4, lower-latin) ". "
        }

        ul.lst-kix_list_34-2 {
            list-style-type: none
        }

        .lst-kix_list_10-5 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_34-3 {
            list-style-type: none
        }

        ol.lst-kix_list_13-5.start {
            counter-reset: lst-ctn-kix_list_13-5 0
        }

        ul.lst-kix_list_34-4 {
            list-style-type: none
        }

        ul.lst-kix_list_34-5 {
            list-style-type: none
        }

        ul.lst-kix_list_34-6 {
            list-style-type: none
        }

        ol.lst-kix_list_20-8 {
            list-style-type: none
        }

        ol.lst-kix_list_13-8.start {
            counter-reset: lst-ctn-kix_list_13-8 0
        }

        ol.lst-kix_list_20-5 {
            list-style-type: none
        }

        ol.lst-kix_list_20-4 {
            list-style-type: none
        }

        ol.lst-kix_list_20-7 {
            list-style-type: none
        }

        .lst-kix_list_11-7 > li {
            counter-increment: lst-ctn-kix_list_11-7
        }

        ol.lst-kix_list_20-6 {
            list-style-type: none
        }

        .lst-kix_list_9-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_20-1 {
            list-style-type: none
        }

        ol.lst-kix_list_20-0 {
            list-style-type: none
        }

        ol.lst-kix_list_20-3 {
            list-style-type: none
        }

        ol.lst-kix_list_20-2 {
            list-style-type: none
        }

        ol.lst-kix_list_37-6.start {
            counter-reset: lst-ctn-kix_list_37-6 0
        }

        ol.lst-kix_list_14-0.start {
            counter-reset: lst-ctn-kix_list_14-0 0
        }

        .lst-kix_list_12-5 > li {
            counter-increment: lst-ctn-kix_list_12-5
        }

        ul.lst-kix_list_34-7 {
            list-style-type: none
        }

        ul.lst-kix_list_34-8 {
            list-style-type: none
        }

        .lst-kix_list_5-5 > li {
            counter-increment: lst-ctn-kix_list_5-5
        }

        .lst-kix_list_36-2 > li:before {
            content: "" counter(lst-ctn-kix_list_36-2, lower-roman) ". "
        }

        .lst-kix_list_31-1 > li {
            counter-increment: lst-ctn-kix_list_31-1
        }

        .lst-kix_list_9-0 > li:before {
            content: "\002714   "
        }

        ul.lst-kix_list_21-1 {
            list-style-type: none
        }

        ul.lst-kix_list_21-2 {
            list-style-type: none
        }

        ul.lst-kix_list_21-3 {
            list-style-type: none
        }

        ul.lst-kix_list_21-4 {
            list-style-type: none
        }

        ul.lst-kix_list_21-5 {
            list-style-type: none
        }

        ul.lst-kix_list_21-6 {
            list-style-type: none
        }

        ul.lst-kix_list_21-7 {
            list-style-type: none
        }

        ul.lst-kix_list_21-8 {
            list-style-type: none
        }

        .lst-kix_list_11-3 > li:before {
            content: "" counter(lst-ctn-kix_list_11-3, decimal) ". "
        }

        ul.lst-kix_list_21-0 {
            list-style-type: none
        }

        .lst-kix_list_38-8 > li {
            counter-increment: lst-ctn-kix_list_38-8
        }

        .lst-kix_list_6-3 > li {
            counter-increment: lst-ctn-kix_list_6-3
        }

        ol.lst-kix_list_33-0 {
            list-style-type: none
        }

        .lst-kix_list_29-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_20-4 > li:before {
            content: "" counter(lst-ctn-kix_list_20-4, lower-latin) ". "
        }

        ol.lst-kix_list_6-1.start {
            counter-reset: lst-ctn-kix_list_6-1 0
        }

        .lst-kix_list_29-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_20-2 > li:before {
            content: "" counter(lst-ctn-kix_list_20-2, lower-roman) ". "
        }

        .lst-kix_list_9-8 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_10-0 {
            list-style-type: none
        }

        .lst-kix_list_28-6 > li {
            counter-increment: lst-ctn-kix_list_28-6
        }

        .lst-kix_list_28-7 > li:before {
            content: "" counter(lst-ctn-kix_list_28-7, lower-latin) ". "
        }

        ul.lst-kix_list_10-8 {
            list-style-type: none
        }

        .lst-kix_list_4-8 > li {
            counter-increment: lst-ctn-kix_list_4-8
        }

        ul.lst-kix_list_10-7 {
            list-style-type: none
        }

        .lst-kix_list_1-7 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_10-6 {
            list-style-type: none
        }

        ul.lst-kix_list_10-5 {
            list-style-type: none
        }

        ul.lst-kix_list_10-4 {
            list-style-type: none
        }

        ul.lst-kix_list_10-3 {
            list-style-type: none
        }

        .lst-kix_list_1-5 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_10-2 {
            list-style-type: none
        }

        .lst-kix_list_28-5 > li:before {
            content: "" counter(lst-ctn-kix_list_28-5, lower-roman) ". "
        }

        ul.lst-kix_list_10-1 {
            list-style-type: none
        }

        .lst-kix_list_5-6 > li {
            counter-increment: lst-ctn-kix_list_5-6
        }

        .lst-kix_list_2-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_19-8 > li {
            counter-increment: lst-ctn-kix_list_19-8
        }

        .lst-kix_list_2-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_11-8 > li {
            counter-increment: lst-ctn-kix_list_11-8
        }

        .lst-kix_list_35-3 > li:before {
            content: "" counter(lst-ctn-kix_list_35-3, decimal) ". "
        }

        .lst-kix_list_30-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_20-8 > li {
            counter-increment: lst-ctn-kix_list_20-8
        }

        .lst-kix_list_35-6 > li:before {
            content: "" counter(lst-ctn-kix_list_35-6, decimal) ". "
        }

        .lst-kix_list_36-5 > li {
            counter-increment: lst-ctn-kix_list_36-5
        }

        .lst-kix_list_3-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_26-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_8-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_6-0 > li {
            counter-increment: lst-ctn-kix_list_6-0
        }

        .lst-kix_list_3-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_30-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_40-2 > li {
            counter-increment: lst-ctn-kix_list_40-2
        }

        ol.lst-kix_list_11-5.start {
            counter-reset: lst-ctn-kix_list_11-5 0
        }

        .lst-kix_list_11-1 > li {
            counter-increment: lst-ctn-kix_list_11-1
        }

        .lst-kix_list_8-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_26-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_21-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_41-3 > li {
            counter-increment: lst-ctn-kix_list_41-3
        }

        ol.lst-kix_list_41-4.start {
            counter-reset: lst-ctn-kix_list_41-4 0
        }

        ol.lst-kix_list_35-3.start {
            counter-reset: lst-ctn-kix_list_35-3 0
        }

        ol.lst-kix_list_4-2.start {
            counter-reset: lst-ctn-kix_list_4-2 0
        }

        .lst-kix_list_21-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_25-5 > li {
            counter-increment: lst-ctn-kix_list_25-5
        }

        ol.lst-kix_list_11-6.start {
            counter-reset: lst-ctn-kix_list_11-6 0
        }

        .lst-kix_list_4-4 > li {
            counter-increment: lst-ctn-kix_list_4-4
        }

        ol.lst-kix_list_6-4.start {
            counter-reset: lst-ctn-kix_list_6-4 0
        }

        .lst-kix_list_17-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_31-8 > li {
            counter-increment: lst-ctn-kix_list_31-8
        }

        .lst-kix_list_25-3 > li:before {
            content: "" counter(lst-ctn-kix_list_25-3, decimal) ". "
        }

        ol.lst-kix_list_4-1.start {
            counter-reset: lst-ctn-kix_list_4-1 0
        }

        .lst-kix_list_16-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_39-2 > li {
            counter-increment: lst-ctn-kix_list_39-2
        }

        .lst-kix_list_16-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_15-3 > li {
            counter-increment: lst-ctn-kix_list_15-3
        }

        ol.lst-kix_list_41-5.start {
            counter-reset: lst-ctn-kix_list_41-5 0
        }

        ol.lst-kix_list_11-0.start {
            counter-reset: lst-ctn-kix_list_11-0 0
        }

        .lst-kix_list_37-6 > li {
            counter-increment: lst-ctn-kix_list_37-6
        }

        .lst-kix_list_39-3 > li:before {
            content: "" counter(lst-ctn-kix_list_39-3, decimal) ". "
        }

        ol.lst-kix_list_6-3.start {
            counter-reset: lst-ctn-kix_list_6-3 0
        }

        ol.lst-kix_list_35-8.start {
            counter-reset: lst-ctn-kix_list_35-8 0
        }

        .lst-kix_list_38-1 > li {
            counter-increment: lst-ctn-kix_list_38-1
        }

        .lst-kix_list_17-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_41-7 > li {
            counter-increment: lst-ctn-kix_list_41-7
        }

        ol.lst-kix_list_35-5.start {
            counter-reset: lst-ctn-kix_list_35-5 0
        }

        .lst-kix_list_2-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_42-8 > li {
            counter-increment: lst-ctn-kix_list_42-8
        }

        .lst-kix_list_14-5 > li {
            counter-increment: lst-ctn-kix_list_14-5
        }

        .lst-kix_list_7-5 > li:before {
            content: "" counter(lst-ctn-kix_list_7-5, lower-roman) ". "
        }

        .lst-kix_list_27-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_19-5 > li {
            counter-increment: lst-ctn-kix_list_19-5
        }

        .lst-kix_list_28-2 > li {
            counter-increment: lst-ctn-kix_list_28-2
        }

        .lst-kix_list_22-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_30-0 > li {
            counter-increment: lst-ctn-kix_list_30-0
        }

        ol.lst-kix_list_11-1.start {
            counter-reset: lst-ctn-kix_list_11-1 0
        }

        ol.lst-kix_list_35-2.start {
            counter-reset: lst-ctn-kix_list_35-2 0
        }

        .lst-kix_list_34-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_18-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_13-6 > li:before {
            content: "" counter(lst-ctn-kix_list_13-6, decimal) ". "
        }

        .lst-kix_list_6-7 > li {
            counter-increment: lst-ctn-kix_list_6-7
        }

        ol.lst-kix_list_41-0.start {
            counter-reset: lst-ctn-kix_list_41-0 0
        }

        .lst-kix_list_39-6 > li:before {
            content: "" counter(lst-ctn-kix_list_39-6, decimal) ". "
        }

        ul.lst-kix_list_30-3 {
            list-style-type: none
        }

        ul.lst-kix_list_30-4 {
            list-style-type: none
        }

        ul.lst-kix_list_30-5 {
            list-style-type: none
        }

        .lst-kix_list_7-5 > li {
            counter-increment: lst-ctn-kix_list_7-5
        }

        .lst-kix_list_15-6 > li:before {
            content: "" counter(lst-ctn-kix_list_15-6, decimal) ". "
        }

        ul.lst-kix_list_30-6 {
            list-style-type: none
        }

        .lst-kix_list_11-4 > li {
            counter-increment: lst-ctn-kix_list_11-4
        }

        ul.lst-kix_list_30-7 {
            list-style-type: none
        }

        ul.lst-kix_list_30-8 {
            list-style-type: none
        }

        .lst-kix_list_31-3 > li:before {
            content: "" counter(lst-ctn-kix_list_31-3, decimal) ". "
        }

        .lst-kix_list_36-7 > li:before {
            content: "" counter(lst-ctn-kix_list_36-7, lower-latin) ". "
        }

        ol.lst-kix_list_6-8.start {
            counter-reset: lst-ctn-kix_list_6-8 0
        }

        .lst-kix_list_10-2 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_30-1 {
            list-style-type: none
        }

        ul.lst-kix_list_30-2 {
            list-style-type: none
        }

        .lst-kix_list_13-7 > li {
            counter-increment: lst-ctn-kix_list_13-7
        }

        .lst-kix_list_20-7 > li:before {
            content: "" counter(lst-ctn-kix_list_20-7, lower-latin) ". "
        }

        ol.lst-kix_list_6-5.start {
            counter-reset: lst-ctn-kix_list_6-5 0
        }

        .lst-kix_list_4-6 > li:before {
            content: "" counter(lst-ctn-kix_list_4-6, decimal) ". "
        }

        .lst-kix_list_41-8 > li:before {
            content: "" counter(lst-ctn-kix_list_41-8, lower-roman) ". "
        }

        .lst-kix_list_25-6 > li:before {
            content: "" counter(lst-ctn-kix_list_25-6, decimal) ". "
        }

        .lst-kix_list_41-0 > li:before {
            content: "" counter(lst-ctn-kix_list_41-0, lower-latin) ") "
        }

        ol.lst-kix_list_6-7.start {
            counter-reset: lst-ctn-kix_list_6-7 0
        }

        .lst-kix_list_12-2 > li {
            counter-increment: lst-ctn-kix_list_12-2
        }

        .lst-kix_list_9-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_29-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_33-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_12-2 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) ". "
        }

        ol.lst-kix_list_41-3.start {
            counter-reset: lst-ctn-kix_list_41-3 0
        }

        .lst-kix_list_11-6 > li:before {
            content: "" counter(lst-ctn-kix_list_11-6, decimal) ". "
        }

        .lst-kix_list_32-7 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_11-3.start {
            counter-reset: lst-ctn-kix_list_11-3 0
        }

        .lst-kix_list_1-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_35-4.start {
            counter-reset: lst-ctn-kix_list_35-4 0
        }

        ol.lst-kix_list_40-8 {
            list-style-type: none
        }

        ol.lst-kix_list_40-6 {
            list-style-type: none
        }

        .lst-kix_list_35-0 > li {
            counter-increment: lst-ctn-kix_list_35-0
        }

        ol.lst-kix_list_40-7 {
            list-style-type: none
        }

        ol.lst-kix_list_41-2.start {
            counter-reset: lst-ctn-kix_list_41-2 0
        }

        ol.lst-kix_list_40-4 {
            list-style-type: none
        }

        ol.lst-kix_list_40-5 {
            list-style-type: none
        }

        ol.lst-kix_list_40-2 {
            list-style-type: none
        }

        ol.lst-kix_list_40-3 {
            list-style-type: none
        }

        ol.lst-kix_list_40-0 {
            list-style-type: none
        }

        ol.lst-kix_list_40-1 {
            list-style-type: none
        }

        .lst-kix_list_40-4 > li:before {
            content: "" counter(lst-ctn-kix_list_40-4, lower-latin) ". "
        }

        ol.lst-kix_list_11-4.start {
            counter-reset: lst-ctn-kix_list_11-4 0
        }

        .lst-kix_list_28-2 > li:before {
            content: "" counter(lst-ctn-kix_list_28-2, lower-roman) ". "
        }

        .lst-kix_list_41-2 > li {
            counter-increment: lst-ctn-kix_list_41-2
        }

        .lst-kix_list_14-1 > li:before {
            content: "" counter(lst-ctn-kix_list_14-1, lower-latin) ". "
        }

        .lst-kix_list_14-3 > li:before {
            content: "" counter(lst-ctn-kix_list_14-3, decimal) ". "
        }

        ol.lst-kix_list_15-6 {
            list-style-type: none
        }

        .lst-kix_list_25-8 > li {
            counter-increment: lst-ctn-kix_list_25-8
        }

        ol.lst-kix_list_15-7 {
            list-style-type: none
        }

        ol.lst-kix_list_15-8 {
            list-style-type: none
        }

        .lst-kix_list_14-0 > li:before {
            content: "(" counter(lst-ctn-kix_list_14-0, upper-roman) ") "
        }

        .lst-kix_list_14-4 > li:before {
            content: "" counter(lst-ctn-kix_list_14-4, lower-latin) ". "
        }

        ol.lst-kix_list_15-2 {
            list-style-type: none
        }

        ol.lst-kix_list_15-3 {
            list-style-type: none
        }

        ol.lst-kix_list_15-4 {
            list-style-type: none
        }

        .lst-kix_list_6-1 > li {
            counter-increment: lst-ctn-kix_list_6-1
        }

        .lst-kix_list_14-5 > li:before {
            content: "" counter(lst-ctn-kix_list_14-5, lower-roman) ". "
        }

        .lst-kix_list_14-7 > li:before {
            content: "" counter(lst-ctn-kix_list_14-7, lower-latin) ". "
        }

        ol.lst-kix_list_15-5 {
            list-style-type: none
        }

        .lst-kix_list_37-5 > li {
            counter-increment: lst-ctn-kix_list_37-5
        }

        ol.lst-kix_list_15-0 {
            list-style-type: none
        }

        .lst-kix_list_14-6 > li:before {
            content: "" counter(lst-ctn-kix_list_14-6, decimal) ". "
        }

        ol.lst-kix_list_15-1 {
            list-style-type: none
        }

        ol.lst-kix_list_7-4.start {
            counter-reset: lst-ctn-kix_list_7-4 0
        }

        ol.lst-kix_list_25-3.start {
            counter-reset: lst-ctn-kix_list_25-3 0
        }

        ol.lst-kix_list_11-8.start {
            counter-reset: lst-ctn-kix_list_11-8 0
        }

        .lst-kix_list_14-2 > li:before {
            content: "" counter(lst-ctn-kix_list_14-2, lower-roman) ". "
        }

        .lst-kix_list_20-7 > li {
            counter-increment: lst-ctn-kix_list_20-7
        }

        ol.lst-kix_list_35-6.start {
            counter-reset: lst-ctn-kix_list_35-6 0
        }

        ul.lst-kix_list_17-1 {
            list-style-type: none
        }

        ol.lst-kix_list_12-0.start {
            counter-reset: lst-ctn-kix_list_12-0 0
        }

        ul.lst-kix_list_17-0 {
            list-style-type: none
        }

        ol.lst-kix_list_28-3.start {
            counter-reset: lst-ctn-kix_list_28-3 0
        }

        ol.lst-kix_list_41-7.start {
            counter-reset: lst-ctn-kix_list_41-7 0
        }

        .lst-kix_list_32-2 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_17-8 {
            list-style-type: none
        }

        .lst-kix_list_32-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_32-3 > li:before {
            content: "\0025cf   "
        }

        ul.lst-kix_list_17-7 {
            list-style-type: none
        }

        ul.lst-kix_list_17-6 {
            list-style-type: none
        }

        ul.lst-kix_list_17-5 {
            list-style-type: none
        }

        .lst-kix_list_28-7 > li {
            counter-increment: lst-ctn-kix_list_28-7
        }

        ul.lst-kix_list_17-4 {
            list-style-type: none
        }

        ul.lst-kix_list_17-3 {
            list-style-type: none
        }

        .lst-kix_list_14-8 > li:before {
            content: "" counter(lst-ctn-kix_list_14-8, lower-roman) ". "
        }

        ul.lst-kix_list_17-2 {
            list-style-type: none
        }

        .lst-kix_list_31-7 > li {
            counter-increment: lst-ctn-kix_list_31-7
        }

        .lst-kix_list_39-7 > li {
            counter-increment: lst-ctn-kix_list_39-7
        }

        .lst-kix_list_32-0 > li:before {
            content: "" counter(lst-ctn-kix_list_32-0, lower-latin) ") "
        }

        ol.lst-kix_list_15-5.start {
            counter-reset: lst-ctn-kix_list_15-5 0
        }

        ol.lst-kix_list_39-8 {
            list-style-type: none
        }

        .lst-kix_list_5-0 > li:before {
            content: "" counter(lst-ctn-kix_list_5-0, decimal-leading-zero) ". "
        }

        ol.lst-kix_list_6-0 {
            list-style-type: none
        }

        ol.lst-kix_list_6-1 {
            list-style-type: none
        }

        .lst-kix_list_14-8 > li {
            counter-increment: lst-ctn-kix_list_14-8
        }

        .lst-kix_list_5-4 > li {
            counter-increment: lst-ctn-kix_list_5-4
        }

        ol.lst-kix_list_39-5 {
            list-style-type: none
        }

        ol.lst-kix_list_39-4 {
            list-style-type: none
        }

        ol.lst-kix_list_39-7 {
            list-style-type: none
        }

        ol.lst-kix_list_39-6 {
            list-style-type: none
        }

        .lst-kix_list_5-3 > li:before {
            content: "" counter(lst-ctn-kix_list_5-3, decimal) ". "
        }

        .lst-kix_list_36-8 > li {
            counter-increment: lst-ctn-kix_list_36-8
        }

        ol.lst-kix_list_39-1 {
            list-style-type: none
        }

        ol.lst-kix_list_39-0 {
            list-style-type: none
        }

        .lst-kix_list_5-2 > li:before {
            content: "" counter(lst-ctn-kix_list_5-2, lower-roman) ". "
        }

        ol.lst-kix_list_39-3 {
            list-style-type: none
        }

        ol.lst-kix_list_39-2 {
            list-style-type: none
        }

        .lst-kix_list_5-1 > li:before {
            content: "" counter(lst-ctn-kix_list_5-1, lower-latin) ". "
        }

        .lst-kix_list_5-7 > li:before {
            content: "" counter(lst-ctn-kix_list_5-7, lower-latin) ". "
        }

        ul.lst-kix_list_8-4 {
            list-style-type: none
        }

        ul.lst-kix_list_8-5 {
            list-style-type: none
        }

        .lst-kix_list_5-6 > li:before {
            content: "" counter(lst-ctn-kix_list_5-6, decimal) ". "
        }

        .lst-kix_list_5-8 > li:before {
            content: "" counter(lst-ctn-kix_list_5-8, lower-roman) ". "
        }

        ul.lst-kix_list_8-2 {
            list-style-type: none
        }

        ul.lst-kix_list_8-3 {
            list-style-type: none
        }

        ul.lst-kix_list_8-8 {
            list-style-type: none
        }

        ul.lst-kix_list_8-6 {
            list-style-type: none
        }

        ul.lst-kix_list_8-7 {
            list-style-type: none
        }

        ol.lst-kix_list_6-6 {
            list-style-type: none
        }

        ol.lst-kix_list_6-7 {
            list-style-type: none
        }

        .lst-kix_list_5-4 > li:before {
            content: "" counter(lst-ctn-kix_list_5-4, lower-latin) ". "
        }

        ol.lst-kix_list_6-8 {
            list-style-type: none
        }

        .lst-kix_list_5-5 > li:before {
            content: "" counter(lst-ctn-kix_list_5-5, lower-roman) ". "
        }

        ol.lst-kix_list_6-2 {
            list-style-type: none
        }

        ul.lst-kix_list_8-0 {
            list-style-type: none
        }

        ol.lst-kix_list_6-3 {
            list-style-type: none
        }

        ul.lst-kix_list_8-1 {
            list-style-type: none
        }

        ol.lst-kix_list_6-4 {
            list-style-type: none
        }

        ol.lst-kix_list_6-5 {
            list-style-type: none
        }

        ol.lst-kix_list_12-5.start {
            counter-reset: lst-ctn-kix_list_12-5 0
        }

        .lst-kix_list_6-1 > li:before {
            content: "" counter(lst-ctn-kix_list_6-1, lower-latin) ". "
        }

        .lst-kix_list_6-3 > li:before {
            content: "" counter(lst-ctn-kix_list_6-3, decimal) ". "
        }

        .lst-kix_list_6-8 > li {
            counter-increment: lst-ctn-kix_list_6-8
        }

        .lst-kix_list_6-0 > li:before {
            content: "" counter(lst-ctn-kix_list_6-0, upper-roman) "- "
        }

        .lst-kix_list_6-4 > li:before {
            content: "" counter(lst-ctn-kix_list_6-4, lower-latin) ". "
        }

        ol.lst-kix_list_14-8.start {
            counter-reset: lst-ctn-kix_list_14-8 0
        }

        .lst-kix_list_6-2 > li:before {
            content: "" counter(lst-ctn-kix_list_6-2, lower-roman) ". "
        }

        ol.lst-kix_list_15-0.start {
            counter-reset: lst-ctn-kix_list_15-0 0
        }

        ol.lst-kix_list_35-1.start {
            counter-reset: lst-ctn-kix_list_35-1 0
        }

        .lst-kix_list_6-8 > li:before {
            content: "" counter(lst-ctn-kix_list_6-8, lower-roman) ". "
        }

        .lst-kix_list_6-5 > li:before {
            content: "" counter(lst-ctn-kix_list_6-5, lower-roman) ". "
        }

        .lst-kix_list_6-7 > li:before {
            content: "" counter(lst-ctn-kix_list_6-7, lower-latin) ". "
        }

        ol.lst-kix_list_42-4.start {
            counter-reset: lst-ctn-kix_list_42-4 0
        }

        .lst-kix_list_6-6 > li:before {
            content: "" counter(lst-ctn-kix_list_6-6, decimal) ". "
        }

        .lst-kix_list_7-4 > li:before {
            content: "" counter(lst-ctn-kix_list_7-4, lower-latin) ". "
        }

        .lst-kix_list_7-6 > li:before {
            content: "" counter(lst-ctn-kix_list_7-6, decimal) ". "
        }

        ol.lst-kix_list_19-7.start {
            counter-reset: lst-ctn-kix_list_19-7 0
        }

        ol.lst-kix_list_6-2.start {
            counter-reset: lst-ctn-kix_list_6-2 0
        }

        .lst-kix_list_15-5 > li {
            counter-increment: lst-ctn-kix_list_15-5
        }

        ol.lst-kix_list_36-3.start {
            counter-reset: lst-ctn-kix_list_36-3 0
        }

        .lst-kix_list_7-2 > li:before {
            content: "" counter(lst-ctn-kix_list_7-2, lower-roman) ". "
        }

        .lst-kix_list_7-6 > li {
            counter-increment: lst-ctn-kix_list_7-6
        }

        .lst-kix_list_31-0 > li {
            counter-increment: lst-ctn-kix_list_31-0
        }

        .lst-kix_list_34-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_31-0 > li:before {
            content: "" counter(lst-ctn-kix_list_31-0, lower-latin) ") "
        }

        .lst-kix_list_12-6 > li {
            counter-increment: lst-ctn-kix_list_12-6
        }

        .lst-kix_list_13-7 > li:before {
            content: "" counter(lst-ctn-kix_list_13-7, lower-latin) ". "
        }

        .lst-kix_list_7-8 > li:before {
            content: "" counter(lst-ctn-kix_list_7-8, lower-roman) ". "
        }

        .lst-kix_list_15-6 > li {
            counter-increment: lst-ctn-kix_list_15-6
        }

        .lst-kix_list_4-7 > li {
            counter-increment: lst-ctn-kix_list_4-7
        }

        .lst-kix_list_15-5 > li:before {
            content: "" counter(lst-ctn-kix_list_15-5, lower-roman) ". "
        }

        ol.lst-kix_list_28-8 {
            list-style-type: none
        }

        .lst-kix_list_31-6 > li:before {
            content: "" counter(lst-ctn-kix_list_31-6, decimal) ". "
        }

        .lst-kix_list_31-8 > li:before {
            content: "" counter(lst-ctn-kix_list_31-8, lower-roman) ". "
        }

        .lst-kix_list_13-4 > li {
            counter-increment: lst-ctn-kix_list_13-4
        }

        ol.lst-kix_list_28-5 {
            list-style-type: none
        }

        ol.lst-kix_list_28-4 {
            list-style-type: none
        }

        ol.lst-kix_list_28-7 {
            list-style-type: none
        }

        ol.lst-kix_list_28-6 {
            list-style-type: none
        }

        ol.lst-kix_list_28-1 {
            list-style-type: none
        }

        ol.lst-kix_list_28-0 {
            list-style-type: none
        }

        .lst-kix_list_4-1 > li:before {
            content: "" counter(lst-ctn-kix_list_4-1, lower-latin) ". "
        }

        .lst-kix_list_31-2 > li:before {
            content: "" counter(lst-ctn-kix_list_31-2, lower-roman) ". "
        }

        .lst-kix_list_31-4 > li:before {
            content: "" counter(lst-ctn-kix_list_31-4, lower-latin) ". "
        }

        ol.lst-kix_list_28-3 {
            list-style-type: none
        }

        ol.lst-kix_list_28-2 {
            list-style-type: none
        }

        .lst-kix_list_15-7 > li:before {
            content: "" counter(lst-ctn-kix_list_15-7, lower-latin) ". "
        }

        .lst-kix_list_36-0 > li {
            counter-increment: lst-ctn-kix_list_36-0
        }

        .lst-kix_list_4-3 > li:before {
            content: "" counter(lst-ctn-kix_list_4-3, decimal) ". "
        }

        .lst-kix_list_4-5 > li:before {
            content: "" counter(lst-ctn-kix_list_4-5, lower-roman) ". "
        }

        ol.lst-kix_list_38-1.start {
            counter-reset: lst-ctn-kix_list_38-1 0
        }

        .lst-kix_list_15-1 > li:before {
            content: "" counter(lst-ctn-kix_list_15-1, lower-latin) ". "
        }

        .lst-kix_list_15-3 > li:before {
            content: "" counter(lst-ctn-kix_list_15-3, decimal) ". "
        }

        .lst-kix_list_42-7 > li {
            counter-increment: lst-ctn-kix_list_42-7
        }

        ol.lst-kix_list_4-4.start {
            counter-reset: lst-ctn-kix_list_4-4 0
        }

        ol.lst-kix_list_39-3.start {
            counter-reset: lst-ctn-kix_list_39-3 0
        }

        .lst-kix_list_40-5 > li {
            counter-increment: lst-ctn-kix_list_40-5
        }

        .lst-kix_list_20-0 > li {
            counter-increment: lst-ctn-kix_list_20-0
        }

        .lst-kix_list_32-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_11-2 > li {
            counter-increment: lst-ctn-kix_list_11-2
        }

        .lst-kix_list_19-2 > li {
            counter-increment: lst-ctn-kix_list_19-2
        }

        .lst-kix_list_33-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_12-3 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) "." counter(lst-ctn-kix_list_12-3, decimal) ". "
        }

        ol.lst-kix_list_31-4.start {
            counter-reset: lst-ctn-kix_list_31-4 0
        }

        .lst-kix_list_38-2 > li {
            counter-increment: lst-ctn-kix_list_38-2
        }

        .lst-kix_list_32-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_12-1 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "- "
        }

        .lst-kix_list_33-0 > li:before {
            content: "" counter(lst-ctn-kix_list_33-0, lower-latin) ") "
        }

        .lst-kix_list_33-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_32-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_13-3 > li {
            counter-increment: lst-ctn-kix_list_13-3
        }

        ol.lst-kix_list_13-6.start {
            counter-reset: lst-ctn-kix_list_13-6 0
        }

        ol.lst-kix_list_40-5.start {
            counter-reset: lst-ctn-kix_list_40-5 0
        }

        ol.lst-kix_list_25-8.start {
            counter-reset: lst-ctn-kix_list_25-8 0
        }

        .lst-kix_list_39-0 > li {
            counter-increment: lst-ctn-kix_list_39-0
        }

        .lst-kix_list_34-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_14-1 > li {
            counter-increment: lst-ctn-kix_list_14-1
        }

        .lst-kix_list_13-3 > li:before {
            content: "" counter(lst-ctn-kix_list_13-3, decimal) ". "
        }

        .lst-kix_list_39-6 > li {
            counter-increment: lst-ctn-kix_list_39-6
        }

        .lst-kix_list_34-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_35-3 > li {
            counter-increment: lst-ctn-kix_list_35-3
        }

        .lst-kix_list_28-0 > li {
            counter-increment: lst-ctn-kix_list_28-0
        }

        .lst-kix_list_42-6 > li {
            counter-increment: lst-ctn-kix_list_42-6
        }

        .lst-kix_list_34-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_13-5 > li:before {
            content: "" counter(lst-ctn-kix_list_13-5, lower-roman) ". "
        }

        .lst-kix_list_12-5 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) "." counter(lst-ctn-kix_list_12-3, decimal) "." counter(lst-ctn-kix_list_12-4, decimal) "." counter(lst-ctn-kix_list_12-5, decimal) ". "
        }

        ol.lst-kix_list_28-8.start {
            counter-reset: lst-ctn-kix_list_28-8 0
        }

        ol.lst-kix_list_13-7.start {
            counter-reset: lst-ctn-kix_list_13-7 0
        }

        .lst-kix_list_36-1 > li {
            counter-increment: lst-ctn-kix_list_36-1
        }

        .lst-kix_list_36-7 > li {
            counter-increment: lst-ctn-kix_list_36-7
        }

        .lst-kix_list_12-7 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) "." counter(lst-ctn-kix_list_12-3, decimal) "." counter(lst-ctn-kix_list_12-4, decimal) "." counter(lst-ctn-kix_list_12-5, decimal) "." counter(lst-ctn-kix_list_12-6, decimal) "." counter(lst-ctn-kix_list_12-7, decimal) ". "
        }

        .lst-kix_list_42-0 > li {
            counter-increment: lst-ctn-kix_list_42-0
        }

        .lst-kix_list_33-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_33-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_34-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_25-1 > li {
            counter-increment: lst-ctn-kix_list_25-1
        }

        .lst-kix_list_13-1 > li:before {
            content: "" counter(lst-ctn-kix_list_13-1, lower-latin) ". "
        }

        ul.lst-kix_list_24-0 {
            list-style-type: none
        }

        .lst-kix_list_30-5 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_24-1 {
            list-style-type: none
        }

        ul.lst-kix_list_24-2 {
            list-style-type: none
        }

        .lst-kix_list_35-0 > li:before {
            content: "" counter(lst-ctn-kix_list_35-0, lower-latin) ") "
        }

        .lst-kix_list_35-1 > li:before {
            content: "" counter(lst-ctn-kix_list_35-1, lower-latin) ". "
        }

        .lst-kix_list_35-4 > li:before {
            content: "" counter(lst-ctn-kix_list_35-4, lower-latin) ". "
        }

        .lst-kix_list_35-5 > li:before {
            content: "" counter(lst-ctn-kix_list_35-5, lower-roman) ". "
        }

        ul.lst-kix_list_24-3 {
            list-style-type: none
        }

        ul.lst-kix_list_24-4 {
            list-style-type: none
        }

        ol.lst-kix_list_40-6.start {
            counter-reset: lst-ctn-kix_list_40-6 0
        }

        ul.lst-kix_list_24-5 {
            list-style-type: none
        }

        ol.lst-kix_list_11-6 {
            list-style-type: none
        }

        ol.lst-kix_list_11-7 {
            list-style-type: none
        }

        .lst-kix_list_28-8 > li {
            counter-increment: lst-ctn-kix_list_28-8
        }

        ol.lst-kix_list_11-8 {
            list-style-type: none
        }

        .lst-kix_list_30-1 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_11-2 {
            list-style-type: none
        }

        ol.lst-kix_list_11-3 {
            list-style-type: none
        }

        .lst-kix_list_3-0 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_11-4 {
            list-style-type: none
        }

        .lst-kix_list_30-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_11-5 {
            list-style-type: none
        }

        ol.lst-kix_list_20-5.start {
            counter-reset: lst-ctn-kix_list_20-5 0
        }

        ol.lst-kix_list_13-1.start {
            counter-reset: lst-ctn-kix_list_13-1 0
        }

        ol.lst-kix_list_11-0 {
            list-style-type: none
        }

        ol.lst-kix_list_11-1 {
            list-style-type: none
        }

        .lst-kix_list_4-0 > li {
            counter-increment: lst-ctn-kix_list_4-0
        }

        .lst-kix_list_31-6 > li {
            counter-increment: lst-ctn-kix_list_31-6
        }

        ul.lst-kix_list_24-6 {
            list-style-type: none
        }

        ul.lst-kix_list_24-7 {
            list-style-type: none
        }

        ol.lst-kix_list_37-5.start {
            counter-reset: lst-ctn-kix_list_37-5 0
        }

        .lst-kix_list_3-4 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_24-8 {
            list-style-type: none
        }

        .lst-kix_list_3-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_8-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_30-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_8-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_38-3 > li {
            counter-increment: lst-ctn-kix_list_38-3
        }

        .lst-kix_list_3-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_8-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_3-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_8-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_19-1 > li {
            counter-increment: lst-ctn-kix_list_19-1
        }

        .lst-kix_list_35-8 > li:before {
            content: "" counter(lst-ctn-kix_list_35-8, lower-roman) ". "
        }

        .lst-kix_list_11-1 > li:before {
            content: "" counter(lst-ctn-kix_list_11-1, lower-latin) ". "
        }

        ol.lst-kix_list_31-0.start {
            counter-reset: lst-ctn-kix_list_31-0 0
        }

        .lst-kix_list_11-0 > li:before {
            content: "" counter(lst-ctn-kix_list_11-0, decimal) ". "
        }

        .lst-kix_list_8-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_35-4 > li {
            counter-increment: lst-ctn-kix_list_35-4
        }

        .lst-kix_list_37-4 > li {
            counter-increment: lst-ctn-kix_list_37-4
        }

        .lst-kix_list_16-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_16-7 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_35-8 {
            list-style-type: none
        }

        .lst-kix_list_4-8 > li:before {
            content: "" counter(lst-ctn-kix_list_4-8, lower-roman) ". "
        }

        ol.lst-kix_list_35-5 {
            list-style-type: none
        }

        ol.lst-kix_list_35-4 {
            list-style-type: none
        }

        .lst-kix_list_4-7 > li:before {
            content: "" counter(lst-ctn-kix_list_4-7, lower-latin) ". "
        }

        ol.lst-kix_list_35-7 {
            list-style-type: none
        }

        .lst-kix_list_14-2 > li {
            counter-increment: lst-ctn-kix_list_14-2
        }

        ol.lst-kix_list_20-0.start {
            counter-reset: lst-ctn-kix_list_20-0 0
        }

        .lst-kix_list_17-0 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_35-6 {
            list-style-type: none
        }

        ol.lst-kix_list_35-1 {
            list-style-type: none
        }

        ol.lst-kix_list_35-0 {
            list-style-type: none
        }

        ol.lst-kix_list_35-3 {
            list-style-type: none
        }

        ol.lst-kix_list_35-2 {
            list-style-type: none
        }

        .lst-kix_list_39-8 > li {
            counter-increment: lst-ctn-kix_list_39-8
        }

        .lst-kix_list_16-0 > li:before {
            content: "\002714   "
        }

        .lst-kix_list_40-6 > li {
            counter-increment: lst-ctn-kix_list_40-6
        }

        ol.lst-kix_list_4-8.start {
            counter-reset: lst-ctn-kix_list_4-8 0
        }

        .lst-kix_list_16-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_16-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_11-3 > li {
            counter-increment: lst-ctn-kix_list_11-3
        }

        ol.lst-kix_list_37-4.start {
            counter-reset: lst-ctn-kix_list_37-4 0
        }

        .lst-kix_list_41-1 > li {
            counter-increment: lst-ctn-kix_list_41-1
        }

        ol.lst-kix_list_39-7.start {
            counter-reset: lst-ctn-kix_list_39-7 0
        }

        .lst-kix_list_17-7 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_38-2.start {
            counter-reset: lst-ctn-kix_list_38-2 0
        }

        .lst-kix_list_17-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_33-0 > li {
            counter-increment: lst-ctn-kix_list_33-0
        }

        .lst-kix_list_17-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_17-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_7-0 > li:before {
            content: "" counter(lst-ctn-kix_list_7-0, upper-roman) "- "
        }

        ol.lst-kix_list_19-6.start {
            counter-reset: lst-ctn-kix_list_19-6 0
        }

        ol.lst-kix_list_13-8 {
            list-style-type: none
        }

        ul.lst-kix_list_26-0 {
            list-style-type: none
        }

        .lst-kix_list_2-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_2-8 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_26-1 {
            list-style-type: none
        }

        ul.lst-kix_list_26-2 {
            list-style-type: none
        }

        ul.lst-kix_list_26-3 {
            list-style-type: none
        }

        ol.lst-kix_list_13-4 {
            list-style-type: none
        }

        ol.lst-kix_list_13-5 {
            list-style-type: none
        }

        ol.lst-kix_list_13-6 {
            list-style-type: none
        }

        ol.lst-kix_list_13-7 {
            list-style-type: none
        }

        ol.lst-kix_list_13-0 {
            list-style-type: none
        }

        ol.lst-kix_list_13-1 {
            list-style-type: none
        }

        ol.lst-kix_list_13-2 {
            list-style-type: none
        }

        .lst-kix_list_7-3 > li:before {
            content: "" counter(lst-ctn-kix_list_7-3, decimal) ". "
        }

        ol.lst-kix_list_13-3 {
            list-style-type: none
        }

        .lst-kix_list_10-0 > li:before {
            content: "\002714   "
        }

        .lst-kix_list_13-8 > li:before {
            content: "" counter(lst-ctn-kix_list_13-8, lower-roman) ". "
        }

        .lst-kix_list_31-1 > li:before {
            content: "" counter(lst-ctn-kix_list_31-1, lower-latin) ". "
        }

        .lst-kix_list_18-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_18-7 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_26-4 {
            list-style-type: none
        }

        ul.lst-kix_list_26-5 {
            list-style-type: none
        }

        ul.lst-kix_list_26-6 {
            list-style-type: none
        }

        ul.lst-kix_list_26-7 {
            list-style-type: none
        }

        ul.lst-kix_list_26-8 {
            list-style-type: none
        }

        ol.lst-kix_list_39-8.start {
            counter-reset: lst-ctn-kix_list_39-8 0
        }

        .lst-kix_list_7-7 > li:before {
            content: "" counter(lst-ctn-kix_list_7-7, lower-latin) ". "
        }

        .lst-kix_list_36-5 > li:before {
            content: "" counter(lst-ctn-kix_list_36-5, lower-roman) ". "
        }

        .lst-kix_list_15-4 > li:before {
            content: "" counter(lst-ctn-kix_list_15-4, lower-latin) ". "
        }

        .lst-kix_list_31-5 > li:before {
            content: "" counter(lst-ctn-kix_list_31-5, lower-roman) ". "
        }

        ol.lst-kix_list_19-1.start {
            counter-reset: lst-ctn-kix_list_19-1 0
        }

        .lst-kix_list_10-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_10-8 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_20-4.start {
            counter-reset: lst-ctn-kix_list_20-4 0
        }

        .lst-kix_list_4-0 > li:before {
            content: "" counter(lst-ctn-kix_list_4-0, decimal-leading-zero) ". "
        }

        .lst-kix_list_36-1 > li:before {
            content: "" counter(lst-ctn-kix_list_36-1, lower-latin) ". "
        }

        ol.lst-kix_list_25-2.start {
            counter-reset: lst-ctn-kix_list_25-2 0
        }

        .lst-kix_list_15-0 > li:before {
            content: "" counter(lst-ctn-kix_list_15-0, upper-roman) "- "
        }

        .lst-kix_list_15-8 > li:before {
            content: "" counter(lst-ctn-kix_list_15-8, lower-roman) ". "
        }

        ol.lst-kix_list_14-3.start {
            counter-reset: lst-ctn-kix_list_14-3 0
        }

        ol.lst-kix_list_38-7.start {
            counter-reset: lst-ctn-kix_list_38-7 0
        }

        .lst-kix_list_15-7 > li {
            counter-increment: lst-ctn-kix_list_15-7
        }

        .lst-kix_list_4-4 > li:before {
            content: "" counter(lst-ctn-kix_list_4-4, lower-latin) ". "
        }

        .lst-kix_list_9-3 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_7-0.start {
            counter-reset: lst-ctn-kix_list_7-0 0
        }

        .lst-kix_list_12-8 > li {
            counter-increment: lst-ctn-kix_list_12-8
        }

        ol.lst-kix_list_13-2.start {
            counter-reset: lst-ctn-kix_list_13-2 0
        }

        ol.lst-kix_list_4-0 {
            list-style-type: none
        }

        ol.lst-kix_list_4-1 {
            list-style-type: none
        }

        ol.lst-kix_list_4-2 {
            list-style-type: none
        }

        ol.lst-kix_list_4-3 {
            list-style-type: none
        }

        ol.lst-kix_list_37-7 {
            list-style-type: none
        }

        ol.lst-kix_list_14-4.start {
            counter-reset: lst-ctn-kix_list_14-4 0
        }

        ol.lst-kix_list_37-6 {
            list-style-type: none
        }

        .lst-kix_list_9-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_29-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_29-8 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_37-8 {
            list-style-type: none
        }

        ol.lst-kix_list_37-3 {
            list-style-type: none
        }

        ol.lst-kix_list_37-2 {
            list-style-type: none
        }

        .lst-kix_list_32-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_37-5 {
            list-style-type: none
        }

        ol.lst-kix_list_37-4 {
            list-style-type: none
        }

        .lst-kix_list_11-4 > li:before {
            content: "" counter(lst-ctn-kix_list_11-4, lower-latin) ". "
        }

        .lst-kix_list_12-4 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) "." counter(lst-ctn-kix_list_12-3, decimal) "." counter(lst-ctn-kix_list_12-4, decimal) ". "
        }

        ol.lst-kix_list_37-1 {
            list-style-type: none
        }

        ol.lst-kix_list_37-0 {
            list-style-type: none
        }

        .lst-kix_list_5-3 > li {
            counter-increment: lst-ctn-kix_list_5-3
        }

        ol.lst-kix_list_37-0.start {
            counter-reset: lst-ctn-kix_list_37-0 0
        }

        .lst-kix_list_29-0 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_4-8 {
            list-style-type: none
        }

        .lst-kix_list_7-4 > li {
            counter-increment: lst-ctn-kix_list_7-4
        }

        .lst-kix_list_33-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_1-0 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_19-2.start {
            counter-reset: lst-ctn-kix_list_19-2 0
        }

        ol.lst-kix_list_38-5.start {
            counter-reset: lst-ctn-kix_list_38-5 0
        }

        ol.lst-kix_list_4-4 {
            list-style-type: none
        }

        .lst-kix_list_11-8 > li:before {
            content: "" counter(lst-ctn-kix_list_11-8, lower-roman) ". "
        }

        ol.lst-kix_list_4-5 {
            list-style-type: none
        }

        ol.lst-kix_list_4-6 {
            list-style-type: none
        }

        .lst-kix_list_12-0 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) ". "
        }

        ol.lst-kix_list_4-7 {
            list-style-type: none
        }

        .lst-kix_list_1-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_13-0 > li:before {
            content: "(" counter(lst-ctn-kix_list_13-0, upper-roman) ") "
        }

        .lst-kix_list_13-4 > li:before {
            content: "" counter(lst-ctn-kix_list_13-4, lower-latin) ". "
        }

        .lst-kix_list_34-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_38-6.start {
            counter-reset: lst-ctn-kix_list_38-6 0
        }

        .lst-kix_list_33-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_19-3.start {
            counter-reset: lst-ctn-kix_list_19-3 0
        }

        .lst-kix_list_2-0 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_4-5 > li {
            counter-increment: lst-ctn-kix_list_4-5
        }

        .lst-kix_list_1-8 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_34-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_12-8 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) "." counter(lst-ctn-kix_list_12-3, decimal) "." counter(lst-ctn-kix_list_12-4, decimal) "." counter(lst-ctn-kix_list_12-5, decimal) "." counter(lst-ctn-kix_list_12-6, decimal) "." counter(lst-ctn-kix_list_12-7, decimal) "." counter(lst-ctn-kix_list_12-8, decimal) ". "
        }

        .lst-kix_list_19-0 > li:before {
            content: "" counter(lst-ctn-kix_list_19-0, upper-roman) "- "
        }

        ol.lst-kix_list_12-6.start {
            counter-reset: lst-ctn-kix_list_12-6 0
        }

        .lst-kix_list_35-5 > li {
            counter-increment: lst-ctn-kix_list_35-5
        }

        .lst-kix_list_19-2 > li:before {
            content: "" counter(lst-ctn-kix_list_19-2, lower-roman) ". "
        }

        ol.lst-kix_list_30-0 {
            list-style-type: none
        }

        .lst-kix_list_7-0 > li {
            counter-increment: lst-ctn-kix_list_7-0
        }

        .lst-kix_list_19-0 > li {
            counter-increment: lst-ctn-kix_list_19-0
        }

        ol.lst-kix_list_42-5.start {
            counter-reset: lst-ctn-kix_list_42-5 0
        }

        .lst-kix_list_36-6 > li {
            counter-increment: lst-ctn-kix_list_36-6
        }

        ol.lst-kix_list_31-3.start {
            counter-reset: lst-ctn-kix_list_31-3 0
        }

        ol.lst-kix_list_19-8.start {
            counter-reset: lst-ctn-kix_list_19-8 0
        }

        ol.lst-kix_list_41-7 {
            list-style-type: none
        }

        ol.lst-kix_list_41-8 {
            list-style-type: none
        }

        ol.lst-kix_list_36-4.start {
            counter-reset: lst-ctn-kix_list_36-4 0
        }

        ol.lst-kix_list_41-5 {
            list-style-type: none
        }

        ol.lst-kix_list_41-6 {
            list-style-type: none
        }

        ol.lst-kix_list_41-3 {
            list-style-type: none
        }

        ol.lst-kix_list_41-4 {
            list-style-type: none
        }

        .lst-kix_list_19-8 > li:before {
            content: "" counter(lst-ctn-kix_list_19-8, lower-roman) ". "
        }

        ol.lst-kix_list_14-7.start {
            counter-reset: lst-ctn-kix_list_14-7 0
        }

        ol.lst-kix_list_41-1 {
            list-style-type: none
        }

        ol.lst-kix_list_41-2 {
            list-style-type: none
        }

        ol.lst-kix_list_20-8.start {
            counter-reset: lst-ctn-kix_list_20-8 0
        }

        ol.lst-kix_list_41-0 {
            list-style-type: none
        }

        .lst-kix_list_19-5 > li:before {
            content: "" counter(lst-ctn-kix_list_19-5, lower-roman) ". "
        }

        .lst-kix_list_19-7 > li:before {
            content: "" counter(lst-ctn-kix_list_19-7, lower-latin) ". "
        }

        .lst-kix_list_37-7 > li:before {
            content: "" counter(lst-ctn-kix_list_37-7, lower-latin) ". "
        }

        .lst-kix_list_13-2 > li {
            counter-increment: lst-ctn-kix_list_13-2
        }

        .lst-kix_list_38-0 > li:before {
            content: "" counter(lst-ctn-kix_list_38-0, lower-latin) ") "
        }

        .lst-kix_list_19-7 > li {
            counter-increment: lst-ctn-kix_list_19-7
        }

        .lst-kix_list_38-1 > li:before {
            content: "" counter(lst-ctn-kix_list_38-1, lower-latin) ". "
        }

        .lst-kix_list_14-3 > li {
            counter-increment: lst-ctn-kix_list_14-3
        }

        ol.lst-kix_list_15-6.start {
            counter-reset: lst-ctn-kix_list_15-6 0
        }

        .lst-kix_list_37-2 > li:before {
            content: "" counter(lst-ctn-kix_list_37-2, lower-roman) ". "
        }

        .lst-kix_list_37-4 > li:before {
            content: "" counter(lst-ctn-kix_list_37-4, lower-latin) ". "
        }

        .lst-kix_list_25-6 > li {
            counter-increment: lst-ctn-kix_list_25-6
        }

        .lst-kix_list_37-5 > li:before {
            content: "" counter(lst-ctn-kix_list_37-5, lower-roman) ". "
        }

        .lst-kix_list_12-1 > li {
            counter-increment: lst-ctn-kix_list_12-1
        }

        ol.lst-kix_list_31-8.start {
            counter-reset: lst-ctn-kix_list_31-8 0
        }

        .lst-kix_list_18-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_38-8 > li:before {
            content: "" counter(lst-ctn-kix_list_38-8, lower-roman) ". "
        }

        .lst-kix_list_40-3 > li {
            counter-increment: lst-ctn-kix_list_40-3
        }

        ol.lst-kix_list_25-4.start {
            counter-reset: lst-ctn-kix_list_25-4 0
        }

        .lst-kix_list_38-3 > li:before {
            content: "" counter(lst-ctn-kix_list_38-3, decimal) ". "
        }

        .lst-kix_list_38-6 > li:before {
            content: "" counter(lst-ctn-kix_list_38-6, decimal) ". "
        }

        ol.lst-kix_list_32-0.start {
            counter-reset: lst-ctn-kix_list_32-0 0
        }

        ul.lst-kix_list_22-0 {
            list-style-type: none
        }

        .lst-kix_list_2-7 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_22-1 {
            list-style-type: none
        }

        ul.lst-kix_list_22-2 {
            list-style-type: none
        }

        .lst-kix_list_41-8 > li {
            counter-increment: lst-ctn-kix_list_41-8
        }

        ul.lst-kix_list_22-3 {
            list-style-type: none
        }

        ul.lst-kix_list_22-4 {
            list-style-type: none
        }

        .lst-kix_list_2-5 > li:before {
            content: "\0025aa   "
        }

        ul.lst-kix_list_22-5 {
            list-style-type: none
        }

        ul.lst-kix_list_22-6 {
            list-style-type: none
        }

        ul.lst-kix_list_22-7 {
            list-style-type: none
        }

        .lst-kix_list_27-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_32-0 {
            list-style-type: none
        }

        .lst-kix_list_18-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_14-6 > li {
            counter-increment: lst-ctn-kix_list_14-6
        }

        .lst-kix_list_39-5 > li:before {
            content: "" counter(lst-ctn-kix_list_39-5, lower-roman) ". "
        }

        .lst-kix_list_39-7 > li:before {
            content: "" counter(lst-ctn-kix_list_39-7, lower-latin) ". "
        }

        .lst-kix_list_10-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_18-4 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_22-8 {
            list-style-type: none
        }

        .lst-kix_list_7-7 > li {
            counter-increment: lst-ctn-kix_list_7-7
        }

        ol.lst-kix_list_42-3.start {
            counter-reset: lst-ctn-kix_list_42-3 0
        }

        ol.lst-kix_list_15-1.start {
            counter-reset: lst-ctn-kix_list_15-1 0
        }

        ol.lst-kix_list_15-4.start {
            counter-reset: lst-ctn-kix_list_15-4 0
        }

        .lst-kix_list_36-6 > li:before {
            content: "" counter(lst-ctn-kix_list_36-6, decimal) ". "
        }

        ol.lst-kix_list_39-2.start {
            counter-reset: lst-ctn-kix_list_39-2 0
        }

        .lst-kix_list_10-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_15-4 > li {
            counter-increment: lst-ctn-kix_list_15-4
        }

        ol.lst-kix_list_7-3.start {
            counter-reset: lst-ctn-kix_list_7-3 0
        }

        .lst-kix_list_36-0 > li:before {
            content: "" counter(lst-ctn-kix_list_36-0, lower-latin) ") "
        }

        .lst-kix_list_36-8 > li:before {
            content: "" counter(lst-ctn-kix_list_36-8, lower-roman) ". "
        }

        ol.lst-kix_list_40-2.start {
            counter-reset: lst-ctn-kix_list_40-2 0
        }

        .lst-kix_list_28-1 > li {
            counter-increment: lst-ctn-kix_list_28-1
        }

        ol.lst-kix_list_5-7.start {
            counter-reset: lst-ctn-kix_list_5-7 0
        }

        ol.lst-kix_list_28-7.start {
            counter-reset: lst-ctn-kix_list_28-7 0
        }

        .lst-kix_list_20-8 > li:before {
            content: "" counter(lst-ctn-kix_list_20-8, lower-roman) ". "
        }

        .lst-kix_list_39-1 > li {
            counter-increment: lst-ctn-kix_list_39-1
        }

        .lst-kix_list_29-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_29-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_20-0 > li:before {
            content: "" counter(lst-ctn-kix_list_20-0, upper-roman) "- "
        }

        .lst-kix_list_9-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_9-4 > li:before {
            content: "o  "
        }

        .lst-kix_list_20-6 > li:before {
            content: "" counter(lst-ctn-kix_list_20-6, decimal) ". "
        }

        ul.lst-kix_list_2-8 {
            list-style-type: none
        }

        ol.lst-kix_list_12-1.start {
            counter-reset: lst-ctn-kix_list_12-1 0
        }

        .lst-kix_list_11-5 > li:before {
            content: "" counter(lst-ctn-kix_list_11-5, lower-roman) ". "
        }

        ul.lst-kix_list_2-2 {
            list-style-type: none
        }

        ul.lst-kix_list_2-3 {
            list-style-type: none
        }

        ul.lst-kix_list_2-0 {
            list-style-type: none
        }

        ul.lst-kix_list_2-1 {
            list-style-type: none
        }

        ol.lst-kix_list_36-2.start {
            counter-reset: lst-ctn-kix_list_36-2 0
        }

        ul.lst-kix_list_2-6 {
            list-style-type: none
        }

        .lst-kix_list_20-6 > li {
            counter-increment: lst-ctn-kix_list_20-6
        }

        .lst-kix_list_1-1 > li:before {
            content: "o  "
        }

        ul.lst-kix_list_2-7 {
            list-style-type: none
        }

        .lst-kix_list_11-7 > li:before {
            content: "" counter(lst-ctn-kix_list_11-7, lower-latin) ". "
        }

        ul.lst-kix_list_2-4 {
            list-style-type: none
        }

        ul.lst-kix_list_2-5 {
            list-style-type: none
        }

        ol.lst-kix_list_25-7.start {
            counter-reset: lst-ctn-kix_list_25-7 0
        }

        ul.lst-kix_list_33-1 {
            list-style-type: none
        }

        .lst-kix_list_1-3 > li:before {
            content: "\0025cf   "
        }

        ul.lst-kix_list_33-2 {
            list-style-type: none
        }

        ul.lst-kix_list_33-3 {
            list-style-type: none
        }

        ul.lst-kix_list_33-4 {
            list-style-type: none
        }

        ul.lst-kix_list_33-5 {
            list-style-type: none
        }

        ul.lst-kix_list_33-6 {
            list-style-type: none
        }

        .lst-kix_list_28-3 > li:before {
            content: "" counter(lst-ctn-kix_list_28-3, decimal) ". "
        }

        ol.lst-kix_list_42-0.start {
            counter-reset: lst-ctn-kix_list_42-0 0
        }

        ul.lst-kix_list_33-7 {
            list-style-type: none
        }

        .lst-kix_list_14-7 > li {
            counter-increment: lst-ctn-kix_list_14-7
        }

        ol.lst-kix_list_7-5.start {
            counter-reset: lst-ctn-kix_list_7-5 0
        }

        ol.lst-kix_list_31-5.start {
            counter-reset: lst-ctn-kix_list_31-5 0
        }

        ol.lst-kix_list_40-4.start {
            counter-reset: lst-ctn-kix_list_40-4 0
        }

        .lst-kix_list_27-7 > li:before {
            content: "o  "
        }

        .lst-kix_list_25-7 > li {
            counter-increment: lst-ctn-kix_list_25-7
        }

        ul.lst-kix_list_33-8 {
            list-style-type: none
        }

        ol.lst-kix_list_39-4.start {
            counter-reset: lst-ctn-kix_list_39-4 0
        }

        .lst-kix_list_28-1 > li:before {
            content: "" counter(lst-ctn-kix_list_28-1, lower-latin) ". "
        }

        ol.lst-kix_list_19-6 {
            list-style-type: none
        }

        .lst-kix_list_35-2 > li:before {
            content: "" counter(lst-ctn-kix_list_35-2, lower-roman) ". "
        }

        ol.lst-kix_list_19-7 {
            list-style-type: none
        }

        ol.lst-kix_list_19-8 {
            list-style-type: none
        }

        .lst-kix_list_30-3 > li:before {
            content: "\0025cf   "
        }

        ol.lst-kix_list_19-2 {
            list-style-type: none
        }

        ol.lst-kix_list_19-3 {
            list-style-type: none
        }

        ol.lst-kix_list_19-4 {
            list-style-type: none
        }

        .lst-kix_list_30-8 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_19-5 {
            list-style-type: none
        }

        .lst-kix_list_35-7 > li:before {
            content: "" counter(lst-ctn-kix_list_35-7, lower-latin) ". "
        }

        ol.lst-kix_list_19-0 {
            list-style-type: none
        }

        ol.lst-kix_list_39-1.start {
            counter-reset: lst-ctn-kix_list_39-1 0
        }

        ol.lst-kix_list_19-1 {
            list-style-type: none
        }

        ol.lst-kix_list_7-7.start {
            counter-reset: lst-ctn-kix_list_7-7 0
        }

        .lst-kix_list_3-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_26-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_14-0 > li {
            counter-increment: lst-ctn-kix_list_14-0
        }

        .lst-kix_list_8-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_36-7.start {
            counter-reset: lst-ctn-kix_list_36-7 0
        }

        ol.lst-kix_list_31-6.start {
            counter-reset: lst-ctn-kix_list_31-6 0
        }

        .lst-kix_list_12-0 > li {
            counter-increment: lst-ctn-kix_list_12-0
        }

        ol.lst-kix_list_12-3.start {
            counter-reset: lst-ctn-kix_list_12-3 0
        }

        ol.lst-kix_list_40-0.start {
            counter-reset: lst-ctn-kix_list_40-0 0
        }

        .lst-kix_list_21-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_8-5 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_28-0.start {
            counter-reset: lst-ctn-kix_list_28-0 0
        }

        .lst-kix_list_15-1 > li {
            counter-increment: lst-ctn-kix_list_15-1
        }

        .lst-kix_list_26-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_3-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_36-3 > li {
            counter-increment: lst-ctn-kix_list_36-3
        }

        .lst-kix_list_21-7 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_5-0.start {
            counter-reset: lst-ctn-kix_list_5-0 0
        }

        .lst-kix_list_11-2 > li:before {
            content: "" counter(lst-ctn-kix_list_11-2, lower-roman) ". "
        }

        ol.lst-kix_list_42-2.start {
            counter-reset: lst-ctn-kix_list_42-2 0
        }

        .lst-kix_list_39-4 > li {
            counter-increment: lst-ctn-kix_list_39-4
        }

        .lst-kix_list_40-4 > li {
            counter-increment: lst-ctn-kix_list_40-4
        }

        ol.lst-kix_list_31-7.start {
            counter-reset: lst-ctn-kix_list_31-7 0
        }

        ol.lst-kix_list_12-4.start {
            counter-reset: lst-ctn-kix_list_12-4 0
        }

        .lst-kix_list_16-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_35-2 > li {
            counter-increment: lst-ctn-kix_list_35-2
        }

        .lst-kix_list_25-2 > li:before {
            content: "" counter(lst-ctn-kix_list_25-2, lower-roman) ". "
        }

        ol.lst-kix_list_5-6.start {
            counter-reset: lst-ctn-kix_list_5-6 0
        }

        .lst-kix_list_16-1 > li:before {
            content: "o  "
        }

        .lst-kix_list_7-3 > li {
            counter-increment: lst-ctn-kix_list_7-3
        }

        .lst-kix_list_25-0 > li {
            counter-increment: lst-ctn-kix_list_25-0
        }

        ol.lst-kix_list_39-0.start {
            counter-reset: lst-ctn-kix_list_39-0 0
        }

        ol.lst-kix_list_28-6.start {
            counter-reset: lst-ctn-kix_list_28-6 0
        }

        .lst-kix_list_19-3 > li {
            counter-increment: lst-ctn-kix_list_19-3
        }

        ol.lst-kix_list_7-8.start {
            counter-reset: lst-ctn-kix_list_7-8 0
        }

        ol.lst-kix_list_28-5.start {
            counter-reset: lst-ctn-kix_list_28-5 0
        }

        .lst-kix_list_12-4 > li {
            counter-increment: lst-ctn-kix_list_12-4
        }

        .lst-kix_list_12-7 > li {
            counter-increment: lst-ctn-kix_list_12-7
        }

        .lst-kix_list_39-2 > li:before {
            content: "" counter(lst-ctn-kix_list_39-2, lower-roman) ". "
        }

        .lst-kix_list_40-0 > li {
            counter-increment: lst-ctn-kix_list_40-0
        }

        .lst-kix_list_17-2 > li:before {
            content: "\0025aa   "
        }

        ol.lst-kix_list_5-5.start {
            counter-reset: lst-ctn-kix_list_5-5 0
        }

        .lst-kix_list_30-0 > li:before {
            content: "" counter(lst-ctn-kix_list_30-0, lower-latin) ") "
        }

        ol.lst-kix_list_40-1.start {
            counter-reset: lst-ctn-kix_list_40-1 0
        }

        .lst-kix_list_17-5 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_6-2 > li {
            counter-increment: lst-ctn-kix_list_6-2
        }

        ol.lst-kix_list_36-6.start {
            counter-reset: lst-ctn-kix_list_36-6 0
        }

        .lst-kix_list_27-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_22-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_7-1 > li:before {
            content: "" counter(lst-ctn-kix_list_7-1, lower-latin) ". "
        }

        .lst-kix_list_13-5 > li {
            counter-increment: lst-ctn-kix_list_13-5
        }

        ol.lst-kix_list_42-6.start {
            counter-reset: lst-ctn-kix_list_42-6 0
        }

        ol.lst-kix_list_28-4.start {
            counter-reset: lst-ctn-kix_list_28-4 0
        }

        ol.lst-kix_list_5-4.start {
            counter-reset: lst-ctn-kix_list_5-4 0
        }

        ol.lst-kix_list_5-1.start {
            counter-reset: lst-ctn-kix_list_5-1 0
        }

        .lst-kix_list_20-3 > li {
            counter-increment: lst-ctn-kix_list_20-3
        }

        .lst-kix_list_25-3 > li {
            counter-increment: lst-ctn-kix_list_25-3
        }

        .lst-kix_list_11-6 > li {
            counter-increment: lst-ctn-kix_list_11-6
        }

        ol.lst-kix_list_28-1.start {
            counter-reset: lst-ctn-kix_list_28-1 0
        }

        .lst-kix_list_31-7 > li:before {
            content: "" counter(lst-ctn-kix_list_31-7, lower-latin) ". "
        }

        .lst-kix_list_4-6 > li {
            counter-increment: lst-ctn-kix_list_4-6
        }

        .lst-kix_list_28-4 > li {
            counter-increment: lst-ctn-kix_list_28-4
        }

        .lst-kix_list_37-1 > li {
            counter-increment: lst-ctn-kix_list_37-1
        }

        .lst-kix_list_4-2 > li:before {
            content: "" counter(lst-ctn-kix_list_4-2, lower-roman) ". "
        }

        .lst-kix_list_15-2 > li:before {
            content: "" counter(lst-ctn-kix_list_15-2, lower-roman) ". "
        }

        .lst-kix_list_36-3 > li:before {
            content: "" counter(lst-ctn-kix_list_36-3, decimal) ". "
        }

        .lst-kix_list_10-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_9-1 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_12-7.start {
            counter-reset: lst-ctn-kix_list_12-7 0
        }

        .lst-kix_list_40-7 > li {
            counter-increment: lst-ctn-kix_list_40-7
        }

        .lst-kix_list_15-8 > li {
            counter-increment: lst-ctn-kix_list_15-8
        }

        .lst-kix_list_40-8 > li:before {
            content: "" counter(lst-ctn-kix_list_40-8, lower-roman) ". "
        }

        .lst-kix_list_41-5 > li {
            counter-increment: lst-ctn-kix_list_41-5
        }

        ol.lst-kix_list_36-8.start {
            counter-reset: lst-ctn-kix_list_36-8 0
        }

        .lst-kix_list_37-8 > li {
            counter-increment: lst-ctn-kix_list_37-8
        }

        .lst-kix_list_31-3 > li {
            counter-increment: lst-ctn-kix_list_31-3
        }

        ol.lst-kix_list_42-8.start {
            counter-reset: lst-ctn-kix_list_42-8 0
        }

        .lst-kix_list_41-4 > li:before {
            content: "" counter(lst-ctn-kix_list_41-4, lower-latin) ". "
        }

        ol.lst-kix_list_12-8.start {
            counter-reset: lst-ctn-kix_list_12-8 0
        }

        .lst-kix_list_20-3 > li:before {
            content: "" counter(lst-ctn-kix_list_20-3, decimal) ". "
        }

        .lst-kix_list_29-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_28-6 > li:before {
            content: "" counter(lst-ctn-kix_list_28-6, decimal) ". "
        }

        .lst-kix_list_1-6 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_42-3 > li {
            counter-increment: lst-ctn-kix_list_42-3
        }

        ol.lst-kix_list_28-2.start {
            counter-reset: lst-ctn-kix_list_28-2 0
        }

        .lst-kix_list_33-7 > li:before {
            content: "o  "
        }

        ol.lst-kix_list_42-7.start {
            counter-reset: lst-ctn-kix_list_42-7 0
        }

        .lst-kix_list_12-6 > li:before {
            content: "" counter(lst-ctn-kix_list_12-0, decimal) "." counter(lst-ctn-kix_list_12-1, decimal) "-" counter(lst-ctn-kix_list_12-2, decimal) "." counter(lst-ctn-kix_list_12-3, decimal) "." counter(lst-ctn-kix_list_12-4, decimal) "." counter(lst-ctn-kix_list_12-5, decimal) "." counter(lst-ctn-kix_list_12-6, decimal) ". "
        }

        .lst-kix_list_40-0 > li:before {
            content: "" counter(lst-ctn-kix_list_40-0, lower-latin) ") "
        }

        .lst-kix_list_34-3 > li:before {
            content: "\0025cf   "
        }

        .lst-kix_list_2-2 > li:before {
            content: "\0025aa   "
        }

        .lst-kix_list_13-2 > li:before {
            content: "" counter(lst-ctn-kix_list_13-2, lower-roman) ". "
        }

        ol.lst-kix_list_5-2.start {
            counter-reset: lst-ctn-kix_list_5-2 0
        }

        ol {
            margin: 0;
            padding: 0
        }

        table td, table th {
            padding: 0
        }

        .c5 {
            margin-left: 0pt;
            padding-top: 0pt;
            list-style-position: inside;
            text-indent: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: justify
        }

        .c6 {
            margin-left: 9pt;
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: justify;
            height: 10pt
        }

        .c2 {
            margin-left: 15pt;
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: justify
        }

        .c17 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: left
        }

        .c10 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: center
        }

        .c7 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: justify
        }

        .c3 {
            vertical-align: baseline;
            font-size: 12pt;
            font-family: "Gadugi";
            font-weight: 700
        }

        .c15 {
            font-weight: 400;
            vertical-align: baseline;
            font-size: 14pt;
            font-family: "Gadugi"
        }

        .c21 {
            vertical-align: baseline;
            font-size: 12pt;
            font-family: "Arial";
            font-weight: 400
        }

        .c22 {
            vertical-align: baseline;
            font-size: 14pt;
            font-family: "Gadugi";
            font-weight: 700
        }

        .c0 {
            vertical-align: baseline;
            font-size: 12pt;
            font-family: "Gadugi";
            font-weight: 400
        }

        .c13 {
            vertical-align: baseline;
            font-size: 12pt;
            font-family: "Arial";
            font-weight: 700
        }

        .c18 {
            vertical-align: baseline;
            font-family: "Gadugi";
            font-weight: 400
        }

        .c1 {
            color: #000000;
            text-decoration: none;
            font-style: normal
        }

        .c19 {
            background-color: #ffffff;
            max-width: 425.2pt;
            padding: 35pt 25pt 35pt 25pt
        }

        .c12 {
            padding: 0;
            margin: 0
        }

        .c9 {
            margin-left: 53pt;
            padding-left: 9pt
        }

        .c24 {
            background-color: #00ff00
        }

        .c11 {
            background-color: #ff0000
        }

        .c23 {
            vertical-align: baseline
        }

        .c14 {
            height: 10pt
        }

        .c4 {
            font-style: italic
        }

        .c8 {
            background-color: #ffff00
        }

        .c20 {
            font-size: 9pt
        }

        .c16 {
            margin-left: 45pt
        }
    </style>
</head>
<body>
<main>
    <h1>CONTRATO DE PRESTAÇÃO DE SERVIÇOS CONTÁBEIS À PRESTADORES DE SERVIÇOS MÉDICOS SEM ESTABELECIMENTO COMERCIAL
        PRÓPRIO</h1>

    <p>
        @if($makeForPj)
            A CONTRATANTE {{ $empresa->razao_social }}
            , pessoa jurídica de direito privado, inscrita no CNPJ sob nº {{ mask($empresa->cnpj, '##.###.###/####-##') }}
            , com sede na {{ $empresa->endereco->logradouro }},
            nº {{ $socioAdministrador->endereco->numero }}{{ $socioAdministrador->endereco->complemento ? `, {$socioAdministrador->endereco->complemento}` : '' }}
            , na cidade de {{ $socioAdministrador->endereco->cidade }}, estado {{ $socioAdministrador->endereco->uf }},
            CEP {{ $socioAdministrador->endereco->cep }}
            , neste ato representada por {{$socioAdministrador->nome_completo}}, inscrito(a) no CPF sob nº {{ mask($socioAdministrador->cpf, '###.###.###-##') }}
        @else
            A(O) CONTRATANTE {{ $socioAdministrador->nome_completo }}, {{ $socioAdministrador->nacionalidade }}
            , {{ $socioAdministrador->estado_civil->nome }}
            , {{ $socioAdministrador->profissao->nome }}{{ $socioAdministrador->crm ? `, inscrito(a) no CRM nº {$socioAdministrador->crm}` : '' }}
            , portador(a) do RG nº {{ $socioAdministrador->rg }}, inscrito(a) no CPF sob
            nº {{ mask($socioAdministrador->cpf, '###.###.###-##') }}, residente e domiciliado(a)
            na {{ $socioAdministrador->endereco->logradouro }},
            nº {{ $socioAdministrador->endereco->numero }}{{ $socioAdministrador->endereco->complemento ? `, {$socioAdministrador->endereco->complemento}` : '' }}
            , na cidade de {{ $socioAdministrador->endereco->cidade }}, estado {{ $socioAdministrador->endereco->uf }},
            CEP {{ $socioAdministrador->endereco->cep }},
        @endif

        ao adquirir os serviços prestados por <strong>MEDB GESTÃO E CONTABILIDADE</strong>, pessoa jurídica de
        direito privado, inscrita no CNPJ sob nº 25.113.801/0001-94, com sede na Avenida Pedro Taques, nº 294, Salas
        1.505 e 1.508, Torre Norte, Zona Armazém, na cidade de Maringá, Estado do Paraná, CEP 87.030-008, doravante
        denominada como CONTRATADA, concorda com todos os termos e condições do presente contrato.</p>

    <p class="c7"><span class="c0 c1">Considerando que: </span></p>
    <ol class="c12 lst-kix_list_14-0 start" start="1">
        <li class="c5"><span class="c0 c1">A legislação brasileira assim autoriza, o presente contrato tramitar&aacute; em ambiente digital, inclusive com relação as assinaturas;</span>
        </li>
        <li class="c5"><span class="c0 c1">A empresa CONTRATADA tem como atividade principal a prestação de serviços cont&aacute;beis; </span>
        </li>
        <li class="c5"><span class="c0 c1">&nbsp;O(A) CONTRATANTE &eacute; pessoa jur&iacute;dica pr&eacute;-constitu&iacute;da ou pessoa f&iacute;sica que constituir&aacute; pessoa jur&iacute;dica, imediatamente ap&oacute;s a assinatura do presente contrato, sendo que, em ambos os casos, objeto contratual se destina exclusivamente &agrave; EMPRESA doravante denominada apenas como CONTRATANTE. </span>
        </li>
    </ol>
    <p class="c7 c14"><span class="c0 c1"></span></p>
    <ol class="c12 lst-kix_list_15-0 start" start="1">
        <li class="c7 c9"><span class="c3">DO OBJETO </span></li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 1&ordf;:</span><span class="c0 c1">&nbsp;O presente contrato se direciona exclusivamente &agrave; Pessoa Jur&iacute;dica CONTRATANTE (PRESTADORA DE SERVIçOS M&Eacute;DICOS SEM ESTABELECIMENTO COMERCIAL PR&Oacute;PRIO), e tem por objeto a prestação de serviços de: </span>
    </p>
    <ul class="c12 start">
        <li class="c5"><span class="c0">Contabilidade </span><span class="c18 c4">(descrição na Cl&aacute;usula 2&ordf;);</span>
        </li>
        <li class="c5"><span class="c0">Preparação de documentos administrativos </span><span
                class="c0 c4">(</span><span class="c4 c18">descrição na Cl&aacute;usula 3&ordf;</span><span
                class="c0 c1">).</span></li>
    </ul>
    <p class="c6"><span class="c0 c1"></span></p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 2&ordf;:</span><span class="c0 c1">&nbsp;O serviço de CONTABILIDADE se direciona &agrave;s empresas com at&eacute; 2 (dois) s&oacute;cios e faturamento mensal de at&eacute; R$ 40.000,00 (quarenta mil reais), incluindo as seguintes atividades: </span>
    </p>
    <ol class="c12 lst-kix_list_30-0 start" start="1">
        <li class="c5"><span class="c0 c1">Planejamento Tribut&aacute;rio;</span></li>
        <li class="c5"><span
                class="c0 c1">C&aacute;lculo e emissão de guias tribut&aacute;rias e de folha de pagamento;</span>
        </li>
        <li class="c5"><span class="c0 c1">Relat&oacute;rios cont&aacute;beis;</span></li>
        <li class="c5"><span class="c0 c1">Acompanhamento da situação fiscal da CONTRATANTE (PJ), junto aos &oacute;rgãos competentes; </span>
        </li>
        <li class="c5"><span class="c0 c1">Emissão de notas fiscais da CONTRATANTE (PJ), em favor de seus contratantes (PJ).</span>
        </li>
        <li class="c5"><span class="c0 c1">Cumprimento de obrigaç&otilde;es acess&oacute;rias mensais - DCTF, EFD CONTRIBUIç&Otilde;ES e EFD REINF;</span>
        </li>
        <li class="c5"><span class="c0 c1">Cumprimento de obrigaç&otilde;es acess&oacute;rias anuais &ndash; DMED, RAIS, DIRF, DEFIS, ECD e ECF;</span>
        </li>
    </ol>

    <p class="c7 c16"><span class="c18 c1 c20">OBS: A declaração de Imposto de Renda Pessoa Jur&iacute;dica est&aacute; inclu&iacute;da nas obrigaç&otilde;es acess&oacute;rias descritas acima nas al&iacute;neas &ldquo;f&rdquo; e &ldquo;g&rdquo;. </span>
    </p>
    <p class="c7 c14 c16"><span class="c0 c1"></span></p>
    <p class="c2" id="h.30j0zll"><span class="c3">Par&aacute;grafo Primeiro: &nbsp;</span><span
            class="c0">O</span><span
            class="c3">&nbsp;</span><span class="c0">rec&aacute;lculo de tributos ser&aacute; realizado mediante solicitação, limitado a 12 (doze) atos suplementares, sendo que, a partir desta quantidade, haver&aacute; cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span><span
            class="c3">&nbsp;</span></p>
    <p class="c2"><span class="c3">Par&aacute;grafo Segundo: </span><span class="c0">Este contrato não abrange o rec&aacute;lculo de tributos lançados por terceiros, ou seja, a emissão de guias relativas a fatos geradores anteriores ao v&iacute;nculo estabelecido por este contrato, ser&aacute; realizada mediante solicitação, com a correspondente cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0 c1">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span></p>
    <p class="c2" id="h.1fob9te"><span class="c3">Par&aacute;grafo Terceiro: </span><span class="c0">Em caso de inadimpl&ecirc;ncia da CONTRATANTE junto ao fisco, mediante solicitação, a CONTRATADA realizar&aacute; pedido de parcelamento junto ao credor, limitado a 1 (um) ato por ano, sendo que, a partir desta quantidade, haver&aacute; cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0 c1">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span></p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quarto:</span><span class="c0 c1">&nbsp;O objeto do presente contrato N&Atilde;O inclui a emissão de Notas Fiscais em favor dos pacientes da CONTRATANTE - sendo eles pessoas f&iacute;sicas ou jur&iacute;dicas &ndash; considerando que esta atividade &eacute; de sua exclusiva responsabilidade. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quinto: </span><span class="c0">Os serviços não descritos nesta cl&aacute;usula, serão realizados mediante solicitação, e estarão sujeitos a cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span></p>
    <p class="c2"><span class="c3">Par&aacute;grafo Sexto: </span><span class="c0">Os serviços de contabilidade citados acima, serão direcionados exclusivamente &agrave; pessoa jur&iacute;dica, sendo que, para a realização de quaisquer serviços relacionados a pessoa f&iacute;sica, vinculada ou não a CONTRATANTE, INCLUSIVE IMPOSTO DE RENDA PESSOA F&Iacute;SICA, haver&aacute; cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0 c1">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span></p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 3&ordf;:</span><span
            class="c0">&nbsp;O serviço de</span><span
            class="c23">&nbsp;</span><span class="c0 c1">PREPARAç&Atilde;O DE DOCUMENTOS ADMINISTRATIVOS inclui a emissão de documentos necess&aacute;rios para instruir procedimentos, aos quais a CONTRATANTE queira se submeter, sendo eles:</span>
    </p>
    <ol class="c12 lst-kix_list_38-0 start" start="1">
        <li class="c5"><span class="c0 c1">Participação em processos seletivos junto a empresas públicas;</span>
        </li>
        <li class="c5"><span class="c0 c1">Participação em processos seletivos junto a empresas privadas (hospitais, planos de saúde, etc.);</span>
        </li>
        <li class="c5"><span class="c0 c1">Abertura de contas banc&aacute;rias;</span></li>
        <li class="c5"><span class="c0 c1">Cadastramento junto ao CRM.</span></li>
    </ol>
    <p class="c2"><span class="c3">Par&aacute;grafo Primeiro:</span><span class="c0">&nbsp;As solicitaç&otilde;es de documentos para instruir a candidatura da CONTRATANTE junto a empresas públicas, se limitam a 2 (dois) atos por ano (al&iacute;nea </span><span
            class="c0 c4">&ldquo;a&rdquo;</span><span class="c0 c1">). </span></p>
    <p class="c2"><span class="c3">Par&aacute;grafo Segundo: </span><span class="c0">As solicitaç&otilde;es de documentos citadas nas al&iacute;neas "b", "c" e "d", somadas, se limitam a 5 (cinco) atos por ano. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Terceiro:</span><span class="c0 c1">&nbsp;Os serviços descritos nesta cl&aacute;usula se limitam a preparação dos documentos solicitados, os quais serão enviados &agrave; CONTRATANTE atrav&eacute;s do endereço eletr&ocirc;nico indicado. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quarto:</span><span class="c0 c1">&nbsp;A contagem descrita nos par&aacute;grafos primeiro e segundo desta cl&aacute;usula, ser&aacute; realizada considerando a solicitação da CONTRATANTE e a entrega dos documentos pela CONTRATADA, sendo irrelevante a concretização ou não da atividade fim para a qual os documentos sejam solicitados</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quinto:</span><span class="c0">&nbsp;As demais solicitaç&otilde;es não especificadas nas al&iacute;neas &ldquo;</span><span
            class="c0 c4">a</span><span class="c0">&rdquo; a &ldquo;</span><span class="c0 c4">d</span><span
            class="c0 c1">&rdquo; desta cl&aacute;usula, serão realizadas mediante solicitação, com a correspondente cobrança de honor&aacute;rios adicionais, de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span>
    </p>
    <p class="c2 c14"><span class="c0 c1"></span></p>
    <ol class="c12 lst-kix_list_15-0" start="2">
        <li class="c7 c9"><span class="c3">DO PREÇO</span></li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 4&ordf;:</span><span class="c0">&nbsp;Pelos serviços descritos no item anterior, a CONTRATANTE pagar&aacute; a quantia de </span><span
            class="c3">R$ 4.272,00 (quatro mil duzentos e setenta e dois reais),</span><span
            class="c21">&nbsp;dividida em 12 (doze) prestaç&otilde;es de </span><span class="c3">R$ 356,00 (trezentos e cinquenta e seis reais)</span><span
            class="c0">,</span><span class="c3">&nbsp;</span><span class="c0">as quais serão</span><span
            class="c3">&nbsp;</span><span
            class="c0 c1">atualizadas pelos &iacute;ndices do INPC.</span></p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 5&ordm;:</span><span class="c0 c1">&nbsp;O valor descrito acima se refere a prestação de serviços &agrave;s empresas com at&eacute; 2 (dois) s&oacute;cios e faturamento mensal de at&eacute; R$ 40.000,00 (quarenta mil reais), sendo que, em não havendo o preenchimento cumulativo destes requisitos, serão cobrados honor&aacute;rios adicionais, nas seguintes proporç&otilde;es: </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Primeiro: </span><span class="c0 c1">Acr&eacute;scimo de R$ 178,00 (cento e setenta e oito reais) para cada faixa de faturamento de R$ 40.000,00 (quarenta mil reais).</span>
    </p>
    <p class="c7 c16"><span class="c0 c1">Exemplos:</span></p>
    <ol class="c12 lst-kix_list_32-0 start" start="1">
        <li class="c5"><span class="c0 c1">Faturamento entre R$ 40.000,01 (quarenta mil reais e um centavo) e R$ 80.000,00 (oitenta mil reais), sujeição a honor&aacute;rios adicionais no importe de R$ 178,00 (cento e setenta e oito reais);</span>
        </li>
        <li class="c5"><span class="c0 c1">Faturamento entre R$ 80.000,01 (oitenta mil reais e um centavo) e R$ 120.000,00 (cento e vinte mil reais) sujeição a honor&aacute;rios adicionais no importe de R$ 356,00 (trezentos e cinquenta e seis reais).</span>
        </li>
    </ol>
    <p class="c2"><span class="c3">Par&aacute;grafo Segundo</span><span class="c0 c1">: Acr&eacute;scimo de R$ 40,00 (quarenta reais) para cada s&oacute;cio adicional.</span>
    </p>
    <p class="c7 c16"><span class="c0 c1">Exemplos: </span></p>
    <ol class="c12 lst-kix_list_33-0 start" start="1">
        <li class="c5"><span class="c0 c1">1 (um) s&oacute;cio adicional, sujeição a honor&aacute;rios adicionais no importe R$ 40,00 (quarenta reais);</span>
        </li>
        <li class="c5"><span class="c0 c1">2 (dois) s&oacute;cios adicionais, sujeição a honor&aacute;rios adicionais no importe R$ 80,00 (oitenta reais);</span>
        </li>
        <li class="c5"><span class="c0 c1">3 (tr&ecirc;s) s&oacute;cios adicionais, sujeição a honor&aacute;rios adicionais no importe R$ 120,00 (cento e vinte reais).</span>
        </li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 6&ordf;:</span><span class="c0 c1">&nbsp;Sujeitam-se a cobrança de honor&aacute;rios adicionais, de acordo com a tabela de preços vigente &agrave; &eacute;poca, os serviços que, embora previstos neste contrato, excedam a quantia determinada. </span>
    </p>
    <p class="c7" id="h.3znysh7"><span class="c3">CL&Aacute;USULA 7&ordf;:</span><span class="c0 c1">&nbsp;Sujeitam-se a cobrança de honor&aacute;rios adicionais, de acordo com a tabela de preços vigente &agrave; &eacute;poca, os serviços extraordin&aacute;rios atrelados a empresa CONTRATANTE que não estejam descritos no Item I, tais como: Alteração contratual, correção de irregularidades preexistentes, encerramento da atividade empresarial, contratação de empregado(a) dom&eacute;stico(a), entre outras. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 8&ordf;:</span><span class="c0 c1">&nbsp;Caso a CONTRATANTE não receba o documento de cobrança para pagamento dos honor&aacute;rios contratuais ou suplementares, dever&aacute; entrar em contato com a CONTRATADA, a fim de obter informação imediata do saldo a pagar, o qual dever&aacute; ser quitado at&eacute; a data do vencimento.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 9&ordf;: </span><span class="c0 c1">Em caso de atraso no pagamento dos honor&aacute;rios, incidir&aacute; multa de 2% (dois por cento) sobre valor devido, acrescido de juros de mora de 1% (um por cento) ao m&ecirc;s e correção monet&aacute;ria atualizada pelos &iacute;ndices do INPC, desde a data do vencimento, at&eacute; a data do efetivo pagamento. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 10:</span><span class="c0 c1">&nbsp;A CONTRATADA poder&aacute;, a qualquer tempo e sem aviso pr&eacute;vio, alterar a forma de aquisição, a forma de agrupamento (pacotes), e/ou o valor dos honor&aacute;rios, todavia, manter&aacute; o preço para os contratos vigentes at&eacute; a data da RENOVAç&Atilde;O EXPRESSA, momento em que, haver&aacute; a adequação &agrave;s novas regras. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo &Uacute;nico:</span><span class="c0 c1">&nbsp;O contrato com as novas regras somente entrar&aacute; em vigor ap&oacute;s o t&eacute;rmino do contrato preexistente, mediante autorização e concord&acirc;ncia expressa da CONTRATANTE. </span>
    </p>
    <p class="c2 c14"><span class="c0 c1"></span></p>
    <ol class="c12 lst-kix_list_15-0" start="3">
        <li class="c7 c9"><span class="c3">DO PRAZO, DA RENOVAç&Atilde;O E DA RESCIS&Atilde;O</span></li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 11:</span><span class="c0 c1">&nbsp;A CONTRATANTE se compromete, a permanecer com os serviços contratados, pelo prazo correspondente a 12 (doze) prestaç&otilde;es mensais, as quais poderão ser consecutivas ou não.</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Primeiro:</span><span class="c0 c1">&nbsp;O in&iacute;cio da contagem do prazo de 12 (doze) prestaç&otilde;es, e por consequ&ecirc;ncia, o in&iacute;cio da cobrança dos honor&aacute;rios firmados neste contrato, se dar&aacute; quando preenchidos os seguintes requisitos, cumulativamente: </span>
    </p>
    <ol class="c12 lst-kix_list_35-0 start" start="1">
        <li class="c5"><span
                class="c0 c1">Habilitação do s&oacute;cio da CONTRATANTE no respectivo Conselho de Classe; </span>
        </li>
        <li class="c5"><span
                class="c0 c1">Aptidão empresarial, mediante a expedição de alvar&aacute; de funcionamento. </span>
        </li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 12:</span><span class="c0 c1">&nbsp;Caso a atividade econ&ocirc;mica da CONTRATANTE, por raz&otilde;es alheias a sua vontade, não seja iniciada imediatamente ap&oacute;s a constituição da empresa (inaptidão profissional ou inaptidão empresarial), o per&iacute;odo de 12 (doze) prestaç&otilde;es não ter&aacute; sua contagem iniciada, e por consequ&ecirc;ncia, não haver&aacute; cobrança de honor&aacute;rios, enquanto a condição permanecer.</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Primeiro:</span><span class="c0 c1">&nbsp;Caso a inatividade da CONTRATANTE seja posterior ao in&iacute;cio de sua atividade econ&ocirc;mica, mediante solicitação expressa, e condicionada a aus&ecirc;ncia de d&eacute;bitos referentes aos honor&aacute;rios, o presente contrato poder&aacute; ser SUSPENSO pelo tempo em que esta condição permanecer. &nbsp;</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Segundo:</span><span class="c0 c1">&nbsp;A suspensão contratual descrita nesta cl&aacute;usula não ter&aacute; efeito retroativo, ou seja, ser&aacute; considerado como per&iacute;odo de inatividade somente aquele ap&oacute;s o pedido expresso de &ldquo;congelamento&rdquo;. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Terceiro: </span><span class="c0">Em caso de suspensão posterior ao in&iacute;cio da atividade econ&ocirc;mica, a CONTRATANTE se obriga ao pagamento dos honor&aacute;rios proporcionais, referentes aos dias de serviços prestados, bem como, se obriga ao pagamento de Taxa de Suspensão no importe de </span><span
            class="c3">R$ 356,00 (trezentos e cinquenta e seis reais), </span><span class="c0">a ser paga 3 (tr&ecirc;s) dias ap&oacute;s o pedido de suspensão.</span><span
            class="c3">&nbsp;</span></p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quarto: </span><span class="c0">Durante a suspensão posterior, para cada 6 (seis) meses de inatividade, a CONTRATANTE pagar&aacute; &agrave; CONTRATADA,</span><span
            class="c3">&nbsp;</span><span class="c0 c1">a quantia de R$ 178,00 (cento e setenta e oito reais), em razão do cumprimento de obrigaç&otilde;es acess&oacute;rias durante o per&iacute;odo. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quinto:</span><span class="c0 c1">&nbsp;A inatividade inicial ou a suspensão posterior, importam no &ldquo;congelamento&rdquo; da contagem do prazo descrito nesta cl&aacute;usula, sendo que, nestas hip&oacute;teses, o computo iniciar&aacute;/prosseguir&aacute; a partir do momento em que a condição suspensiva desaparecer. &nbsp;</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 13:</span><span class="c0 c1">&nbsp;O prazo descrito neste contrato diz respeito ao per&iacute;odo de 12 (doze) meses de efetiva atividade da CONTRATADA, excetuando-se o per&iacute;odo de inatividade inicial ou suspensão posterior.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 14: </span><span class="c0 c1">Ao final do prazo de 12 (doze) prestaç&otilde;es, em não havendo manifestação expressa contr&aacute;ria, haver&aacute; a renovação autom&aacute;tica do presente contrato por igual per&iacute;odo, restando mantidas todas as regras impostas, inclusive, com relação as penalidades rescis&oacute;rias, desde que, sejam mantidas as mesmas disposiç&otilde;es contratuais, inclusive com relação ao preço.</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Primeiro:</span><span class="c0 c1">&nbsp;Todavia, caso haja alteração da forma de aquisição, da forma de agrupamento (pacotes), ou do valor dos honor&aacute;rios, a renovação somente se dar&aacute; de forma EXPRESSA, momento em que, a CONTRATANTE ser&aacute; cientificada quanto as novas regras e manifestar&aacute; o seu aceite, se assim o quiser. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Segundo: </span><span class="c0">Não ser&aacute; considerada como alteração do valor dos honor&aacute;rios, a atualização inflacion&aacute;ria do valor contratual. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 15:</span><span class="c0 c1">&nbsp;O presente contrato poder&aacute; ser rescindido por qualquer das partes, desde que a parte contr&aacute;ria seja previamente avisada com anteced&ecirc;ncia m&iacute;nima de 30 (trinta) dias, observada a penalidade da Cl&aacute;usula 19.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 16:</span><span class="c0 c1">&nbsp;Em caso de inadimpl&ecirc;ncia por parte da CONTRATANTE por per&iacute;odo superior a 10 (dez) dias, a CONTRATADA rescindir&aacute; o presente contrato, mediante notificação eletr&ocirc;nica com 20 (vinte) dias de anteced&ecirc;ncia. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 17:</span><span class="c0 c1">&nbsp;O não cumprimento, pela CONTRATANTE de qualquer cl&aacute;usula ou condição acordada neste contrato, constitui motivo justo para a rescisão contratual, mediante notificação eletr&ocirc;nica com 30 (trinta) dias de anteced&ecirc;ncia, observada a penalidade da Cl&aacute;usula 19.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 18:</span><span class="c0 c1">&nbsp;Nas hip&oacute;teses de rescisão descritas acima, ficar&aacute; mantido o v&iacute;nculo, inclusive financeiro, at&eacute; o termo final do contrato, eximindo-se a CONTRATADA de qualquer responsabilidade a partir da data da rescisão. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 19:</span><span class="c0 c1">&nbsp;Em caso de rescisão contratual anterior ao prazo fixado no presente contrato, por causa ou intenção da CONTRATANTE, ficar&aacute; a mesma, obrigada ao pagamento de multa de 50% (cinquenta por cento) sobre o valor das parcelas vincendas.</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo &Uacute;nico:</span><span class="c0 c1">&nbsp;Não incidir&aacute; a multa aqui descrita em caso de rescisão do presente instrumento, para a contratação de outros serviços prestados pela CONTRATADA.</span>
    </p>
    <p class="c7 c14"><span class="c0 c1"></span></p>
    <ol class="c12 lst-kix_list_15-0" start="4">
        <li class="c7 c9"><span class="c3">DO DESCONTO CONDICIONAL &ndash; RESID&Ecirc;NCIA M&Eacute;DICA</span>
        </li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 20:</span><span class="c0">&nbsp;Caso o(a) s&oacute;cio(a) da empresa CONTRATANTE, curse Resid&ecirc;ncia M&eacute;dica, com ingresso anterior ou durante a vig&ecirc;ncia do presente contrato, enquanto esta condição permanecer, pelos serviços prestados ser&aacute; cobrado o valor </span><span
            class="c3">R$ 3.360,00 (tr&ecirc;s mil, trezentos e sessenta reais),</span><span
            class="c0">&nbsp;</span><span
            class="c3">&nbsp;</span><span class="c21">dividido em 12 (doze) prestaç&otilde;es de </span><span
            class="c3">R$ 280,00 (duzentos e oitenta reais),</span><span
            class="c0">&nbsp;devidamente</span><span class="c3">&nbsp;</span><span class="c0 c1">atualizado pelos &iacute;ndices do INPC.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 21:</span><span class="c0 c1">&nbsp;O desconto descrito na cl&aacute;usula anterior ser&aacute; concedido em caso de preenchimento integral dos seguintes requisitos: </span>
    </p>
    <ol class="c12 lst-kix_list_36-0 start" start="1">
        <li class="c5"><span
                class="c0 c1">S&oacute;cio(a) da empresa CONTRATANTE cursando Resid&ecirc;ncia M&eacute;dica;</span>
        </li>
        <li class="c5"><span class="c0 c1">Empresa CONTRATANTE com at&eacute; 2 (dois) s&oacute;cios;</span></li>
        <li class="c5"><span
                class="c0 c1">Faturamento da empresa CONTRATANTE de at&eacute; R$ 20.000,00 (vinte mil reais).</span>
        </li>
    </ol>
    <p class="c2"><span class="c3">Par&aacute;grafo &Uacute;nico:</span><span class="c0">&nbsp;O não preenchimento das condiç&otilde;es descritas nas al&iacute;neas "a", "b" e "c",<span
                class="c0 c1"> importa em revogação imediata do desconto concedido, sendo que, a partir de então, vigorar&aacute; a regra geral quanto ao preço e aos serviços prestados (Item II).</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 22:</span><span class="c0">&nbsp;Os benefici&aacute;rios do desconto condicional previsto neste item, se submetem ao contido na Cl&aacute;usula 2&ordf;, no que tange aos serviços prestados (al&iacute;neas </span><span
            class="c0 c4">&ldquo;a&rdquo;</span><span class="c0">&nbsp;a </span><span
            class="c0 c4">&ldquo;g&rdquo;</span><span
            class="c0 c1">), todavia, não se submetem aos par&aacute;grafos 1&ordm; ao 6&ordm; da Cl&aacute;usula 2&ordf;, tampouco se submetem ao conteúdo da Cl&aacute;usula 3&ordf;, tendo em vista as regras pr&oacute;prias que serão melhor detalhadas nos par&aacute;grafos seguintes deste item.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 23:</span><span class="c0 c1">&nbsp;Ser&aacute; disponibilizado aos benefici&aacute;rios do desconto condicional, o serviço de PREPARAç&Atilde;O DE DOCUMENTOS ADMINISTRATIVOS, que inclui a emissão de documentos necess&aacute;rios para instruir procedimentos, aos quais, a CONTRATANTE queira se submeter, como por exemplo: </span>
    </p>
    <ol class="c12 lst-kix_list_39-0 start" start="1">
        <li class="c5"><span class="c0 c1">Participação em processos seletivos junto a empresas públicas;</span>
        </li>
        <li class="c5"><span class="c0 c1">Participação em processos seletivos junto a empresas privadas (hospitais, planos de saúde, etc.);</span>
        </li>
        <li class="c5"><span class="c0 c1">Abertura de contas banc&aacute;rias;</span></li>
        <li class="c5"><span class="c0 c1">Cadastramento junto ao CRM.</span></li>
    </ol>
    <p class="c2"><span class="c3">Par&aacute;grafo Primeiro:</span><span class="c0 c1">&nbsp;A solicitação de documentos para instruir a candidatura da CONTRATANTE junto a empresas públicas, limita-se a 2 (dois) atos por ano. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Segundo:</span><span class="c0 c1">&nbsp;As solicitaç&otilde;es de documentos citadas nas al&iacute;neas "b", "c" e "d", somadas, se limitam a 3 (tr&ecirc;s) atos por ano.</span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Terceiro:</span><span class="c0 c1">&nbsp;Os serviços descritos nesta cl&aacute;usula se limitam a preparação dos documentos solicitados, os quais serão enviados &agrave; CONTRATANTE atrav&eacute;s do endereço eletr&ocirc;nico indicado. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo Quarto:</span><span class="c0 c1">&nbsp;A contagem descrita nos par&aacute;grafos primeiro e segundo desta cl&aacute;usula, ser&aacute; realizada considerando a solicitação da CONTRATANTE e a entrega dos documentos pela CONTRATADA, sendo irrelevante a concretização ou não da atividade fim para a qual os documentos sejam solicitados. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 24:</span><span class="c0">&nbsp; Os benefici&aacute;rios do desconto condicional terão direito ao rec&aacute;lculo de tributos, a ser realizado mediante solicitação, limitado 1 (um) ato por m&ecirc;s, sendo que, a partir desta quantidade, haver&aacute; cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span><span
            class="c3">&nbsp;</span></p>
    <p class="c2"><span class="c3">Par&aacute;grafo &Uacute;nico: </span><span class="c0">Este contrato não abrange o rec&aacute;lculo de tributos lançados por terceiros, ou seja, a emissão de guias relativas a fatos geradores anteriores ao v&iacute;nculo estabelecido por este contrato, ser&aacute; realizada mediante solicitação, com a correspondente cobrança de honor&aacute;rios adicionais,</span><span
            class="c3">&nbsp;</span><span
            class="c0 c1">de acordo com a tabela de preços vigente &agrave; &eacute;poca.</span></p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 25: </span><span class="c0 c1">Sujeitam-se a cobrança de honor&aacute;rios adicionais, de acordo com a tabela de preços vigente &agrave; &eacute;poca, os serviços não contidos neste item, ou, os que, embora previstos, excedam a quantia determinada. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 26:</span><span class="c0 c1">&nbsp;Em caso de revogação do desconto previsto, &eacute; assegurado o direito adquirido em favor da CONTRATANTE durante o per&iacute;odo em que as condiç&otilde;es forem integralmente cumpridas. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 27</span><span class="c0 c1">: Em caso de rescisão contratual anterior ao prazo fixado no presente contrato, por causa ou intenção da CONTRATANTE, resta revogado o desconto condicional, ficando a mesma, obrigada ao pagamento de multa de 50% (cinquenta por cento) sobre o valor integral das parcelas vincendas. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 28:</span><span class="c0 c1">&nbsp;Mant&ecirc;m-se as demais cl&aacute;usulas descritas no presente contrato. </span>
    </p>
    <p class="c7 c14"><span class="c0 c1"></span></p>
    <ol class="c12 lst-kix_list_15-0" start="5">
        <li class="c7 c9"><span class="c3">DISPOSIÇ&Otilde;ES GERAIS</span></li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 29: </span><span class="c0 c1">O cumprimento dos serviços decorrentes do presente contrato contratual, depende de &ldquo;Certificado Digital&rdquo; em nome da CONTRATANTE, tanto pessoa f&iacute;sica, quanto pessoa jur&iacute;dica, sendo que, a emissão e/ou renovação desta tecnologia, fica a seu cargo e responsabilidade. </span>
    </p>
    <p class="c2"><span class="c3">Par&aacute;grafo &Uacute;nico:</span><span class="c0 c1">&nbsp;Todavia, a CONTRATANTE autoriza que, por conveni&ecirc;ncia, necessidade ou imposição do &oacute;rgão competente, todo e qualquer ato inerente ao presente contrato contratual poder&aacute; ser realizado com a utilização do Certificado Digital do contador nomeado pela CONTRATADA. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 30:</span><span class="c0 c1">&nbsp;A CONTRATADA não assume nenhuma responsabilidade pelas consequ&ecirc;ncias advindas de informaç&otilde;es, declaraç&otilde;es ou documentos inid&ocirc;neos ou incompletos que lhe forem apresentados, bem como, por omiss&otilde;es realizadas pela CONTRATANTE ou decorrentes do desrespeito &agrave; orientação prestada.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 31:</span><span class="c0 c1">&nbsp;Qualquer toler&acirc;ncia &agrave; infring&ecirc;ncia de qualquer das cl&aacute;usulas deste contrato ou o não exerc&iacute;cio pela CONTRATADA de quaisquer dos direitos que lhe são assegurados, constituir&aacute; ato de mera liberalidade de sua parte, não implicando em causa de alteração ou novação contratual, al&eacute;m de não prejudicar o exerc&iacute;cio desses direitos em &eacute;pocas subsequentes ou em id&ecirc;ntica ocorr&ecirc;ncia posterior.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 32:</span><span class="c0 c1">&nbsp;No ato da contratação e no decorrer do per&iacute;odo de vig&ecirc;ncia do presente contrato, a CONTRATANTE se compromete a fornecer informaç&otilde;es verdadeiras, atualizadas e completas. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 33:</span><span class="c0 c1">&nbsp;A CONTRATADA se compromete a não divulgar quaisquer informaç&otilde;es ou dados da CONTRATANTE, a menos que seja obrigada a faz&ecirc;-lo em função dos seguintes casos: </span>
    </p>
    <ol class="c12 lst-kix_list_41-0 start" start="1">
        <li class="c5"><span class="c0 c1">Cumprimento de qualquer ordem judicial, ou cumprimento de ordem proferida por &oacute;rgão regulat&oacute;rio competente; </span>
        </li>
        <li class="c5"><span class="c0 c1">Cumprimento de disposição constante na legislação brasileira atual ou que venha a vigorar; </span>
        </li>
        <li class="c5"><span
                class="c0 c1">Cumprimento dos termos do serviço, de acordo com o presente contrato.</span>
        </li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 34:</span><span class="c0 c1">&nbsp;Qualquer disposição deste contrato que seja considerada proibida, inv&aacute;lida ou inexequ&iacute;vel, em nenhuma hip&oacute;tese invalidar&aacute; ou afetar&aacute; o contrato como um todo, ou as demais disposiç&otilde;es aqui previstas.</span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 35:</span><span class="c0 c1">&nbsp;A rescisão de pleno direito do presente contrato por iniciativa da CONTRATADA, não implica em devolução de qualquer quantia j&aacute; paga, tampouco de imposição de multa. </span>
    </p>
    <p class="c7"><span class="c3">CL&Aacute;USULA 36: </span><span class="c0 c1">Em havendo necessidade, serão tomadas medidas judiciais cab&iacute;veis para a reparaç&otilde;es de danos, ou cominação de sanç&otilde;es penais e civis previstas na legislação brasileira, devendo as custas e honor&aacute;rios advocat&iacute;cios serem custeados pela CONTRATANTE. </span>
    </p>
    <p class="c7 c14"><span class="c0 c1"></span></p>
    <ol class="c12 lst-kix_list_15-0" start="6">
        <li class="c7 c9"><span class="c3">DO ACEITE </span></li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 37:</span><span class="c0 c1">&nbsp;A adesão a este contrato ocorre de forma autom&aacute;tica com o aceite da CONTRATANTE via web.</span>
    </p>
    <ol class="c12 lst-kix_list_15-0" start="7">
        <li class="c7 c9"><span class="c3">DO FORO</span></li>
    </ol>
    <p class="c7"><span class="c3">CL&Aacute;USULA 38: </span><span class="c0 c1">O foro competente para dirimir quaisquer dúvidas ou controv&eacute;rsias resultantes deste contrato &eacute; o da cidade de Maring&aacute;, Estado do Paran&aacute;, por mais privilegiado que outro possa ser. </span>
    </p>

    <br/>

    <p>Desta forma, obrigam-se, ambas as partes, em todos os seus encargos e condições.</p>

    <br/>


    <p style="text-align: center">Maringá - Paraná, {{ date('d/m/Y') }}</p>

    <br/>

    <p style="text-align: center">
        <strong>MEDB GESTÃO E CONTABILIDADE</strong>
        <br/>
        CNPJ 25.113.801/0001-94
    </p>

    <br/>

    <p style="text-align: center">
        <strong>{{ $socioAdministrador->nome_completo }}</strong>
        <br/>
        CPF {{ mask($socioAdministrador->cpf, '###.###.###-##') }}
    </p>
</main>
</body>
</html>
