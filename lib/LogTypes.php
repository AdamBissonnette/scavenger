<?php

abstract class LogTypes
{
    const DIRECTION_UNKNOWN = 1;
    const DIRECTION_INCOMING = 2;
    const DIRECTION_OUTGOING = 3;

    //callbacks
    const TYPE_UNKNOWN = 1;
    const TYPE_CLUE = 2;
    const TYPE_ANSWER = 3;
    const TYPE_HINT = 4;
    const TYPE_GLOBAL = 5;
    const TYPE_START = 6;
    const TYPE_END = 7;

    //webhooks
    const TYPE_GET_PARTY = 30;
    const TYPE_POST_PARTY = 31;
    const TYPE_POST_USER = 32;
    const TYPE_POST_HUNT = 33;
    const TYPE_DELETE_USER = 34;
}