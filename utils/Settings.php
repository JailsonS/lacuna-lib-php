<?php

namespace Utils;

class Settings 
{
    public static function set()
    {
        return [

            /* 
            | -------------------------------------------------------------------------------------------------------------
            | Web PKI Configuration
            | -------------------------------------------------------------------------------------------------------------
            */
            'webPki' => [

                // Base64-encoded binary license for the Web PKI. This value is passed to Web PKI component's constructor.
                'license' => null
            ],

            /* 
            | -------------------------------------------------------------------------------------------------------------
            | Rest PKI Configuration
            | -------------------------------------------------------------------------------------------------------------
            */
            'restPki' => [

                /*
                | -------------------------------------------------------------------------------------------------------------
                |     >>>> PASTE YOU ACCESS TOKEN BELOW <<<<
                | -------------------------------------------------------------------------------------------------------------
                */
                'accessToken' => 'N-eZpk6bwdMqu3SpxgAkvCZlcUtWpjGDfyWu0BI0K2YDWc2awuds3nTRd-pcv3WkIldPRhS5Pco6scy37tjgjJX3HVEFZ9Cv7RxU2ay1TIhroEiVyXuc53oHNZokSkMi6F1DwMG-zN49W-aUVakqxkn-0E_SXw_f5bVsU8Orsniiu5Pw_D3taMWlsjuFewDUCWw0rkF1IxpHEtpV60vjma43MdW_hFeTeYPMaRReLuGLq8gQa11_l9F2Br6IGX4XnDlYB61Ns7RlI3LqCEqoBBqgK2xTt9mnVN6MlKYnaslcP4tRnHZfelajLGjto6UIzzi1N2g4YmvYaQMFCCw1DPh_TOPwQnEBGGqdkyJo593-Ldq8Xi9-nTWMiN7oQpHJeEsNg8cJfzmb77AzbS2UT8D7_8YlA5BXqDvUzM8B8NqMgRGhdirXUUMtOfLOPacKhERxsyfngWCnwEoljcTrbKMsbjx9eqnWldNWEfWhWjwCagQy5g3oMePb4iUn0j2lWC7DoA',
                // Address of your Rest PKI installation (with the trailing '/' character)
                'endpoint' => null
            ]
        ];
    }
}
