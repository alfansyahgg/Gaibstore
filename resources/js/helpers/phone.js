import parsePhoneNumber from "libphonenumber-js";

export default function (number, code) {
    return parsePhoneNumber(number, code);
}
