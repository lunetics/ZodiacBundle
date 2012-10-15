Usage of the Zodiac Twig Filters
==========================

There are 2 different Twig filters for this bundle. The

For all examples, the locale `en` and date `01.01.1980` is given, which results to the western zodiac **capricorn** and
chinese zodiac **monkey**

'zodiac' Filter
=============
The `zodiac` filter can be used with a date string or DateTime object. By default the filter returns a translated zodiac
string of the given date.

``` html
{{ user.birthday|zodiac }}
```
will return
``` html
Capricorn
```
Parameters
----------
The zodiac filter has different parameters. They are applied as array, e.g.:
``` html
{{ user.birthday|zodiac({'parameter': value}) }}
```

### Parameter 'type'
Default is set to **null**
This parameter is a **string** or **null** value.  Currently valid strings for 'type' are:
* null
  * Returns a western animal zodiac
* 'chinese'
  * Returns the chinese zodiac for the year

``` html
{{ user.birthday|zodiac({'type': 'chinese'}) }}
```
will return
``` html
Monkey
```

### Parameter 'raw'
Default is set to **false**
This parameter is a **boolean** value. If set to **true**, it will only return the raw/slug identifier for the zodiac. Mostly useful if you want to save it to a database or similar.
**This parameter has priority over the `translationkey` parameter. If set to true, you are not able to retrieve the `translationkey`**
``` html
{{ user.birthday|zodiac({'raw': true}) }}
```
will return
``` html
capricorn
```
### Parameter 'translationkey'
Default is set to **false**
This parameter is a **boolean** value. If set to **true**, it will return a translatable key for your own translation.

``` html
{{ user.birthday|zodiac({'translationkey': true}) }}
```
will return
``` html
lunetics_zodiac.astronomical.capricorn
```

'zodiac_sign' Filter
=============
The `zodiac_sign` filter can be used with a date string or DateTime object. By default the filter returns an unicode sign of the zodiac

``` html
{{ user.birthday|zodiac_sign }}
```
will return
``` html
♑
```
Parameters
----------
The zodiac_sign filter has different parameters. They are applied as array, e.g.:
``` html
{{ user.birthday|zodiac_sign({'parameter': value}) }}
```

### Parameter 'type'
Default is set to **null**
This parameter is a **string** or **null** value.  Currently valid strings for 'type' are:
* null
  * Returns a western animal zodiac
* 'chinese'
  * Returns the chinese zodiac for the year

``` html
{{ user.birthday|zodiac_sign({'type': 'chinese'}) }}
```
will return
``` html
猴
```

### Parameter 'format'
Default is set to **unicode**
This parameter is a **string** value.  Currently valid strings for 'format' are:
* 'unicode'
  * Returns a unicode encoded sign
* 'html'
  * Returns the sign as html-entity 

``` html
{{ user.birthday|zodiac_sign({'type': 'chinese'})|raw }}
```
will return
``` html
&#9809;
```
**IMPORTANT! Since you want the html-entity not escaped, you NEED to apply the `raw` Twig filter afterwards!**
