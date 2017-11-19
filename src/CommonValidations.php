<?php

namespace Mtrajano\LaravelValidations;

class CommonValidations
{
    /**
     * Will validate any float value between -90 and 90 inclusively
     *
     * @return bool
     */
    public function validateLatitude($attribute, $value, $parameters, $validator)
    {
        return is_numeric($value) && $value >= -90 && $value <= 90;
    }

    /**
     * Will validate any float value between -180 and 180 inclusively
     *
     * @return bool
     */
    public function validateLongitude($attribute, $value, $parameters, $validator)
    {
        return is_numeric($value) && $value >= -180 && $value <= 180;
    }

    /**
     * Validates phones in the following format:
     *      (201) 234 1234
     *      201-234-1234
     *      201.234.1234
     *      2012341234
     *
     * @todo add valid area codes, contry codes, prefixes and possible extensions
     *
     * @return bool
     */
    public function validatePhone($attribute, $value, $parameters, $validator)
    {
        $pattern = '/^\(?\d{3}\)?[\s\-\.]?\d{3}[\s\-\.]?\d{4}$/';

        return preg_match($pattern, $value) > 0;
    }

    /**
     * Needs to pass the mod10 checksum to be a valid routing number
     *
     * @see https://en.wikipedia.org/wiki/Routing_transit_number#Check_digit
     *
     * @return true
     */
    public function validateRoutingNumber($attribute, $value, $parameters, $validator)
    {
        $isNumeric = is_numeric($value);
        $correctLength = strlen($value) === 9;

        $checkSum = function($num) {
            $sum = 0;
            $sum += ($num / pow(10, 8) % 10) * 3;
            $sum += ($num / pow(10, 7) % 10) * 7;
            $sum += ($num / pow(10, 6) % 10) * 1;
            $sum += ($num / pow(10, 5) % 10) * 3;
            $sum += ($num / pow(10, 4) % 10) * 7;
            $sum += ($num / pow(10, 3) % 10) * 1;
            $sum += ($num / pow(10, 2) % 10) * 3;
            $sum += ($num / pow(10, 1) % 10) * 7;
            $sum += ($num / pow(10, 0) % 10) * 1;

            return $sum;
        };

        return $isNumeric && $correctLength && $checkSum($value) % 10 === 0;
    }

    /**
     * Checks for a valid US ZIP and ZIP+4 zipcodes
     *
     * @return bool
     */
    public function validateZipCode($attribute, $value, $parameters, $validator)
    {
        $pattern = '/^\d{5}(-\d{4})?$/';

        return preg_match($pattern, $value) > 0;
    }

    /**
     * @see http://www.nationsonline.org/oneworld/country_code_list.htm
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function validateCountryCode($attribute, $value, $parameters, $validator)
    {
        $type = !empty($parameters) ? head($parameters) : 'iso2';

        switch ($type) {
            case 'iso2':
                return $this->validateCountryCodeISO2($attribute, $value, $parameters, $validator);
            case 'iso3':
                return $this->validateCountryCodeISO3($attribute, $value, $parameters, $validator);
            default:
                throw new \InvalidArgumentException('Invalid country code type passed');
        }
    }

    /**
     * @see http://www.nationsonline.org/oneworld/country_code_list.htm
     *
     * @return bool
     */
    protected function validateCountryCodeISO2($attribute, $value, $parameters, $validator)
    {
        $pattern = '/^(AF|AX|AL|DZ|AS|AD|AO|AI|AQ|AG|AR|AM|AW|AU|AT|AZ|BS|BH|BD|BB|BY|BE|BZ|BJ|BM|BT|BO|BA|BW|BV|BR|VG|IO|BN|BG|BF|BI|KH|CM|CA|CV|KY|CF|TD|CL|CN|HK|MO|CX|CC|CO|KM|CG|CD|CK|CR|CI|HR|CU|CY|CZ|DK|DJ|DM|DO|EC|EG|SV|GQ|ER|EE|ET|FK|FO|FJ|FI|FR|GF|PF|TF|GA|GM|GE|DE|GH|GI|GR|GL|GD|GP|GU|GT|GG|GN|GW|GY|HT|HM|VA|HN|HU|IS|IN|ID|IR|IQ|IE|IM|IL|IT|JM|JP|JE|JO|KZ|KE|KI|KP|KR|KW|KG|LA|LV|LB|LS|LR|LY|LI|LT|LU|MK|MG|MW|MY|MV|ML|MT|MH|MQ|MR|MU|YT|MX|FM|MD|MC|MN|ME|MS|MA|MZ|MM|NA|NR|NP|NL|AN|NC|NZ|NI|NE|NG|NU|NF|MP|NO|OM|PK|PW|PS|PA|PG|PY|PE|PH|PN|PL|PT|PR|QA|RE|RO|RU|RW|BL|SH|KN|LC|MF|PM|VC|WS|SM|ST|SA|SN|RS|SC|SL|SG|SK|SI|SB|SO|ZA|GS|SS|ES|LK|SD|SR|SJ|SZ|SE|CH|SY|TW|TJ|TZ|TH|TL|TG|TK|TO|TT|TN|TR|TM|TC|TV|UG|UA|AE|GB|US|UM|UY|UZ|VU|VE|VN|VI|WF|EH|YE|ZM|ZW)$/i';

        return preg_match($pattern, $value) > 0;
    }

    /**
     * @see http://www.nationsonline.org/oneworld/country_code_list.htm
     *
     * @return bool
     */
    protected function validateCountryCodeISO3($attribute, $value, $parameters, $validator)
    {
        $pattern = '/^(AFG|ALA|ALB|DZA|ASM|AND|AGO|AIA|ATA|ATG|ARG|ARM|ABW|AUS|AUT|AZE|BHS|BHR|BGD|BRB|BLR|BEL|BLZ|BEN|BMU|BTN|BOL|BIH|BWA|BVT|BRA|VGB|IOT|BRN|BGR|BFA|BDI|KHM|CMR|CAN|CPV|CYM|CAF|TCD|CHL|CHN|HKG|MAC|CXR|CCK|COL|COM|COG|COD|COK|CRI|CIV|HRV|CUB|CYP|CZE|DNK|DJI|DMA|DOM|ECU|EGY|SLV|GNQ|ERI|EST|ETH|FLK|FRO|FJI|FIN|FRA|GUF|PYF|ATF|GAB|GMB|GEO|DEU|GHA|GIB|GRC|GRL|GRD|GLP|GUM|GTM|GGY|GIN|GNB|GUY|HTI|HMD|VAT|HND|HUN|ISL|IND|IDN|IRN|IRQ|IRL|IMN|ISR|ITA|JAM|JPN|JEY|JOR|KAZ|KEN|KIR|PRK|KOR|KWT|KGZ|LAO|LVA|LBN|LSO|LBR|LBY|LIE|LTU|LUX|MKD|MDG|MWI|MYS|MDV|MLI|MLT|MHL|MTQ|MRT|MUS|MYT|MEX|FSM|MDA|MCO|MNG|MNE|MSR|MAR|MOZ|MMR|NAM|NRU|NPL|NLD|ANT|NCL|NZL|NIC|NER|NGA|NIU|NFK|MNP|NOR|OMN|PAK|PLW|PSE|PAN|PNG|PRY|PER|PHL|PCN|POL|PRT|PRI|QAT|REU|ROU|RUS|RWA|BLM|SHN|KNA|LCA|MAF|SPM|VCT|WSM|SMR|STP|SAU|SEN|SRB|SYC|SLE|SGP|SVK|SVN|SLB|SOM|ZAF|SGS|SSD|ESP|LKA|SDN|SUR|SJM|SWZ|SWE|CHE|SYR|TWN|TJK|TZA|THA|TLS|TGO|TKL|TON|TTO|TUN|TUR|TKM|TCA|TUV|UGA|UKR|ARE|GBR|USA|UMI|URY|UZB|VUT|VEN|VNM|VIR|WLF|ESH|YEM|ZMB|ZWE)$/i';

        return preg_match($pattern, $value) > 0;
    }

    /**
     * @see https://en.wikipedia.org/wiki/Universally_unique_identifier
     *
     * @return bool
     */
    public function validateUUID($attribute, $value, $parameters, $validator)
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        return preg_match($pattern, $value) > 0;
    }
}