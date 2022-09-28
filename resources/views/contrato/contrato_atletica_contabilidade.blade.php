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
    <h1>CONTRATO DE PRESTAÇÃO DE SERVIÇOS – ATLÉTICAS ACADÊMICAS</h1>

    <p>Pelo presente instrumento particular e na melhor forma de direito, as partes abaixo nomeadas e qualificadas, têm
        entre si, ajustada e acertada a celebração do presente Contrato de Prestação de Serviços, o qual tramitará em
        ambiente digital, a reger-se pelas disposições legais vigentes e pelas cláusulas e condições dispostas a
        seguir:</p>

    <p>
    <h1>CAPÍTULO I – DAS PARTES</h1>
    @if($makeForPj)
        <strong>CONTRATANTE</strong> {{ $empresa->razao_social }}
        , pessoa jurídica de direito privado, inscrita no CNPJ sob
        nº {{ mask($empresa->cnpj, '##.###.###/####-##') }}
        , com sede na {{ $empresa->endereco->logradouro }},
        nº {{ $socioAdministrador->endereco->numero }}{{ $socioAdministrador->endereco->complemento ? `, {$socioAdministrador->endereco->complemento}` : '' }}
        , na cidade de {{ $socioAdministrador->endereco->cidade }}, estado {{ $socioAdministrador->endereco->uf }},
        CEP {{ $socioAdministrador->endereco->cep }}
        , neste ato representada por {{$socioAdministrador->nome_completo}}, inscrito(a) no CPF sob
        nº {{ mask($socioAdministrador->cpf, '###.###.###-##') }}
    @else
        <strong>CONTRATANTE</strong> {{ $socioAdministrador->nome_completo }}, {{ $socioAdministrador->nacionalidade }}
        , {{ $socioAdministrador->estado_civil->nome }}
        , {{ $socioAdministrador->profissao->nome }}{{ $socioAdministrador->crm ? `, inscrito(a) no CRM nº {$socioAdministrador->crm}` : '' }}
        , portador(a) do RG nº {{ $socioAdministrador->rg }}, inscrito(a) no CPF sob
        nº {{ mask($socioAdministrador->cpf, '###.###.###-##') }}, residente e domiciliado(a)
        na {{ $socioAdministrador->endereco->logradouro }},
        nº {{ $socioAdministrador->endereco->numero }}{{ $socioAdministrador->endereco->complemento ? `, {$socioAdministrador->endereco->complemento}` : '' }}
        , na cidade de {{ $socioAdministrador->endereco->cidade }}, estado {{ $socioAdministrador->endereco->uf }},
        CEP {{ $socioAdministrador->endereco->cep }},
    @endif

    doravante denominado(a) como CONTRATANTE.
    </p>
    <p><strong>CONTRATADA: MEDB GESTÃO E CONTABILIDADE LTDA</strong>, pessoa jurídica de
        direito privado, inscrita no CNPJ sob nº 25.113.801/0001-94, com sede na Avenida Pedro Taques, nº 294, Salas
        1.505 e 1.508, Torre Norte, Zona Armazém, na cidade de Maringá, Estado do Paraná, CEP 87.030-008, doravante
        denominada como CONTRATADA.
    <h1>CAPÍTULO II – DO OBJETO</h1>
    <strong>CLÁUSULA PRIMEIRA:</strong> O presente contrato tem por objeto a prestação do serviço de <strong>ASSESSORIA
        CONTÁBIL</strong>, contendo as seguintes atividades:
    <ol class="c12 lst-kix_list_14-0 start" start="1">
        <li class="c5"><span class="c0 c1">Contabilização (entradas e saídas);</span>
        </li>
        <li class="c5"><span class="c0 c1">Encerramento do balanço contábil; </span>
        </li>
        <li class="c5"><span class="c0 c1">Entrega de obrigações contábeis e fiscais;</li>
        <li class="c5"><span class="c0 c1">Emissão de certidões;</li>
        <li class="c5"><span class="c0 c1">Orientação para regularização da atlética (atuação exclusivamente consultiva).
        </li>
    </ol>
    <strong>Parágrafo Único:</strong> Os serviços não descritos nesta cláusula, serão realizados mediante solicitação, e
    estarão sujeitos
    a cobrança de honorários adicionais, de acordo com a tabela de preços vigente à época.
    <h1>CAPÍTULO III - DO PRAZO</h1>
    <strong>CLÁUSULA SEGUNDA:</strong> A vigência do presente contrato se dará pelo prazo de 36 (trinta e seis) meses,
    contados a partir da data de sua assinatura.
    </p>
    <h1>CAPÍTULO IV – DO PREÇO</h1>
    <p>
        <strong>CLÁUSULA TERCEIRA:</strong> Pelos serviços descritos na Cláusula Primeira, a Contratante se compromete a
        pagar o importe de
        <strong>R$ 6.408,00 (seis mil, quatrocentos e oito reais), em 36 (trinta e seis) vezes de R$ 178,00 (cento e
            setenta
            e oito
            reais)</strong>, o qual será atualizado pelos índices do IGPM ou INPC.
    </p>
    <p><strong>CLÁUSULA QUARTA:</strong> Em caso de atraso no pagamento dos honorários descritos na Cláusula Terceira,
        incidirá multa de 2%
        (dois por cento) sobre valor devido, acrescido de juros de mora de 1% (um por cento) ao mês e correção monetária
        atualizada pelos índices do IGPM ou INPC, desde a data do vencimento, até a data do efetivo pagamento.</p>

    <p>
        <strong>CLÁUSULA QUINTA:</strong> Contudo, por livre liberalidade das partes, em substituição ao pagamento em
        pecúnia descrito na
        Cláusula Terceira, em contrapartida aos serviços descritos na Cláusula Primeira, a CONTRATANTE se compromete a:
    <ol class="c12 lst-kix_list_14-0 start" start="1">
        <li class="c5"><span class="c0 c1">Expor a logo da CONTRATADA na camiseta a ser utilizada na INTERMED ou em qualquer outro evento em que a CONTRATANTE comparecer vinculada a sua atividade principal;</span>
        </li>
        <li class="c5"><span class="c0 c1">Postar 1 (um) story por mês no Instagram oficial da CONTRATANTE com a exposição da arte criada pela CONTRATADA; </span>
        </li>
        <li class="c5"><span class="c0 c1">Realizar 6 (seis) publicações por ano no feed do Instagram oficial da CONTRATANTE, com a exposição da arte criada pela CONTRATADA;
        </li>
        <li class="c5"><span class="c0 c1">Disponibilizar os e-mails e os números de telefones dos associados para que a CONTRATADA possa enviar conteúdo de divulgação de sua marca.
        </li>
    </ol>
    </p>
    <p>
    <h1>CAPÍTULO V – DA RENOVAÇÃO E DA RESCISÃO</h1>
    <strong>CLÁUSULA SEXTA:</strong> A CONTRATANTE se compromete, a permanecer com os serviços contratados, durante o
    período de 36 (trinta e seis) meses subsequentes a assinatura deste instrumento
    </p>
    <p>
        <strong>Parágrafo Primeiro:</strong> Ao final do prazo estipulado no caput, em não havendo manifestação expressa
        contrária,
        haverá a renovação automática do presente contrato por igual período, caso a CONTRATADA mantenha as mesmas
        práticas comerciais, tais como: forma de aquisição, forma de agrupamento (pacotes), valor dos honorários, dentre
        outras.
    </p>
    <p>
        <strong>Parágrafo Segundo:</strong> Todavia, em caso de alteração das práticas comerciais da CONTRATADA, o
        contrato com as novas
        regras somente entrará em vigor após o término do contrato preexistente, mediante autorização e concordância
        expressa da CONTRATANTE.
    </p>
    <p>
        <strong>CLÁUSULA SÉTIMA:</strong> O presente instrumento poderá ser rescindido por qualquer das partes, desde
        que a parte
        contrária seja previamente avisada com antecedência mínima de 30 (trinta) dias, mantendo-se o vínculo, inclusive
        financeiro/obrigacional, até o termo final do contrato.
    </p>
    <p>
        <strong>CLÁUSULA OITAVA:</strong> Caso a CONTRATANTE opte ou dê razão à rescisão contratual antes do prazo
        previsto na Cláusula
        Sexta, restará obrigada ao pagamento proporcional correspondente a 40% (quarenta) por cento dos valores
        descritos na Cláusula Terceira, referente as parcelas vincendas
    </p>
    <p>
        <strong>Parágrafo Primeiro:</strong> Em caso de inadimplência por parte da CONTRATANTE (financeira ou
        obrigacional), a CONTRATADA
        fará a prévia comunicação de rescisão com antecedência de 15 (quinze) dias, eximindo-se de qualquer
        responsabilidade a partir da data da rescisão, ficando a CONTRATANTE sujeita as penalidades contidas na Cláusula
        Oitava.
    </p>
    <p>
        <strong>Parágrafo Segundo:</strong> Após a rescisão contratual por opção ou causa da CONTRATANTE, a multa
        descrita no caput (40%)
        NÃO será exigida, caso a mesma realize as atividades descritas na Cláusula Quinta até a data prevista para o
        término da vigência contratual (Cláusula Sexta).
    </p>
    <p>
        <strong>CLÁUSULA NONA:</strong> A rescisão por intenção da CONTRATADA, não implica em devolução de qualquer
        quantia já paga,
        tampouco de imposição de multa, devendo apenas haver prévia comunicação com antecedência de 30 (trinta) dias.
    </p>
    <p>
    <h1>CAPÍTULO VI – DAS RESPONSABILIDADES</h1>
    <strong>CLÁUSULA DÉCIMA:</strong> O uso da marca da CONTRATADA é transitório e subordinado ao cumprimento das
    cláusulas deste
    contrato, não podendo ser vinculada a outra forma ou propósito.
    </p>
    <p>
    <h1>CAPÍTULO VII- DAS DISPOSIÇÕES GERAIS</h1>
    <strong>CLÁUSULA DÉCIMA PRIMEIRA:</strong> O cumprimento dos serviços decorrentes do presente contrato, depende de
    “Certificado
    Digital” em nome da CONTRATANTE, sendo que, a emissão e/ou renovação desta tecnologia, fica a seu cargo e
    responsabilidade.
    </p>
    <p>
        <strong>Parágrafo Único:</strong> Todavia, a CONTRATANTE autoriza que, por conveniência, necessidade ou
        imposição do órgão
        competente, todo e qualquer ato inerente ao presente contrato poderá ser realizado com a utilização do
        Certificado Digital do contador nomeado pela CONTRATADA.
    </p>
    <p>
        <strong>CLÁUSULA DÉCIMA SEGUNDA:</strong> A CONTRATADA não assume nenhuma responsabilidade pelas consequências
        advindas de
        informações, declarações ou documentos inidôneos ou incompletos que lhe forem apresentados, bem como, por
        omissões realizadas pela CONTRATANTE ou decorrentes do desrespeito à orientação prestada.
    </p>
    <p>
        <strong>CLÁUSULA DÉCIMA TERCEIRA:</strong> A tolerância à infringência de qualquer das cláusulas deste contrato
        ou o não
        exercício pela CONTRATADA de quaisquer dos direitos que lhe são assegurados, constituirá ato de mera
        liberalidade de sua parte, não implicando em causa de alteração ou novação contratual, além de não prejudicar o
        exercício desses direitos em épocas subsequentes ou em idêntica ocorrência posterior.
    </p>
    <p>
        <strong>CLÁUSULA DÉCIMA QUARTA:</strong> No ato da contratação e no decorrer do período de vigência do presente
        contrato, a
        CONTRATANTE se compromete a fornecer informações verdadeiras, atualizadas e completas.
    </p>
    <p>
        <strong>CLÁUSULA DÉCIMA QUINTA:</strong> A CONTRATADA se compromete a não divulgar quaisquer informações ou
        dados da CONTRATANTE,
        a menos que seja obrigada a fazê-lo em função dos seguintes casos:
    <ol class="c12 lst-kix_list_14-0 start" start="1">
        <li class="c5"><span class="c0 c1">Cumprimento de ordem judicial, ou cumprimento de ordem proferida por órgão regulatório competente; </span>
        </li>
        <li class="c5"><span class="c0 c1">Cumprimento de disposição constante na legislação brasileira atual ou que venha a vigorar;</span>
        </li>
        <li class="c5"><span class="c0 c1">Cumprimento dos termos do serviço, de acordo com o presente contrato.
        </li>
        </li>
    </ol>
    </p>
    <p>
        <strong>CLÁUSULA DÉCIMA SEXTA:</strong> Qualquer disposição deste contrato que seja considerada proibida,
        inválida ou
        inexequível, em nenhuma hipótese invalidará ou afetará o contrato como um todo, ou as demais disposições aqui
        previstas.
    </p>
    <p>
        <strong>CLÁUSULA DÉCIMA SÉTIMA:</strong> Em havendo descumprimento contratual ou danos causados pela CONTRANTE,
        serão tomadas
        medidas administrativas e/ou judiciais cabíveis, devendo as custas e os honorários advocatícios serem custeados
        pela parte que der causa a demanda.
    </p>
    <p>
    <h1>CAPÍTULO VIII – DO FORO</h1>
    <strong>CLÁUSULA DÉCIMA OITAVA:</strong> Fica eleito o foro da comarca de Maringá, estado do Paraná, para dirimir conflitos oriundos
    do presente Contrato, com a exclusão de qualquer outro, por mais privilegiado que seja.
    E, para que o presente instrumento produza os efeitos legais e de direito as partes, de comum acordo, firmam o
    presente contrato na modalidade digital.
    </p>

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
