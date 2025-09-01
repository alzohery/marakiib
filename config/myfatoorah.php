<?php

return [

    /**
     * API Token Key (string)
     * Accepted value:
     * Live Token: https://myfatoorah.readme.io/docs/live-token
     * Test Token: https://myfatoorah.readme.io/docs/test-token
     */
    'api_key' => 'CH9J_O1-UmpnfsRQQPfTmg04e2n4KihzAncA5P5XPRgaycY8ox3OsqRWx49GIenbSvLvzGbFMJGef0Nk60aoIcBvtIcT9dd18ZzZ42uuB6uBKgH3Fr-puzubDWG_2VOC-jc6a4Nez-cd4eZqcYUogAJ2tXkv-6dsU4t5h5RaD-x4RojtLmXtVJRtjedCTMm53qros9_ka7qnvDJeDUB0VQuqf0CMeINl8b5Xoiir3ruWHDLK57DxjM-1xw3fMKdqGb1T_Yqwt32siW5JZ6QobZvP0-9xdBWyRwTTxwQWDtkBS1NQmrdYIH0TfisCd-t9lYEdTO30Vv3DtxIRKne4b69OwB3x-4AK9WnwMCzJfn6047wAinaBI8za_xkj1GqECjukb3JIeVv4fm_kIARsMcxPPGDBZ_lPyaaHP4IJuPS_BIOC9PI0FPJDP_8mCQrWu_3U4MVqNUw-ab9iq6owqH4XBclHkaCPDttkbI40sbOg4omchdCjlUdb9vq9RUpP8cSUemtyQR1pIpSPEMH1l8ivwMJHJOAJrRRj4biCTr7fP5_epIfTgJJ-6pmP0gZV2xXHUHcrbGb7wcUnG1rIYgJT8LmL9V_lLoYFKT0dhDYwLJTUOLfcVJNKUiUdWMpCgrd4N7vkCsifIolI5yzam6IXR9rDWzJOim1vhJNZK3WGseEMt7EDE5W5Op3oUHN6CjGC-A',
    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => true,
    /**
     * Country ISO Code (string)
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => 'EGY',
    /**
     * Save card (boolean)
     * Accepted value: true if you want to enable save card options.
     * You should contact your account manager to enable this feature in your MyFatoorah account as well.
     */
    'save_card' => true,
    /**
     * Webhook secret key (string)
     * Enable webhook on your MyFatoorah account setting then paste the secret key here.
     * The webhook link is: https://{example.com}/myfatoorah/webhook
     */
    'webhook_secret_key' => '',
    /**
     * Register Apple Pay (boolean)
     * Set it to true to show the Apple Pay on the checkout page.
     * First, verify your domain with Apple Pay before you set it to true.
     * You can either follow the steps here: https://docs.myfatoorah.com/docs/apple-pay#verify-your-domain-with-apple-pay or contact the MyFatoorah support team (tech@myfatoorah.com).
    */
    'register_apple_pay' => false
];
