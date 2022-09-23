import { Metadata } from "libphonenumber-js";
import { byIso } from "country-code-lookup";
const { _ } = window;
const countries = new Metadata().metadata.countries;

const items = [];
for (const country in countries) {
    const find = byIso(country);
    if (find) {
        items.push({
            value: country,
            text: find.country,
            code: `+${countries[country][0]}`,
        });
    }
}

export default _.sortBy(items, ["value"]);