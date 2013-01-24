

function transliterate(text) {
        var table = {
            'а' : 'a',
            'б' : 'b',
            'в' : 'v',
            'г' : 'g',
            'ґ' : 'g',
            'д' : 'd',
            'е' : 'e',
            'є' : 'e',
            'ё' : 'jo',
            'ж' : 'zh',
            'з' : 'z',
            'и' : 'i',
            'і' : 'i',
            'ї' : 'i',
            'й' : 'i',
            'к' : 'k',
            'л' : 'l',
            'м' : 'm',
            'н' : 'n',
            'о' : 'o',
            'п' : 'p',
            'р' : 'r',
            'с' : 's',
            'т' : 't',
            'у' : 'u',
            'ф' : 'f',
            'х' : 'h',
            'ц' : 'ts',
            'ч' : 'ch',
            'ш' : 'sh',
            'щ' : 'sch',
            'ь' : '',
            'ы' : 'y',
            'ъ' : '',
            'э' : 'e',
            'ю' : 'ju',
            'я' : 'ja',
            ' ' : '-',
            '-' : '-'
        };

        var buffer = text.toLowerCase();
        buffer = buffer.replace(/^\s+|\s+$/g, '');
        for (key in table) {
            buffer = buffer.replace(new RegExp(key, 'g'), table[key]);
        }
        // remove other chars
        buffer = buffer.replace(/[^-\w\s]/g, '-');
        buffer = buffer.replace(/[-\s]+/g, '-');
        buffer = buffer.replace(/^\-/g, '');
        buffer = buffer.replace(/\-$/g, '');
        //buffer = buffer.replace(/\W/g, '');
        return buffer;

    }