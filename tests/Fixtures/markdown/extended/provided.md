# Header 1

A very short paragraph proceeding a list

- List item 1
- And list item 2

## Header 2 ##      {#custom-id}

1. Item 1
2. And item 2

```php
<?php

echo "Something"
```

*[HTML]: Hyper Text Markup Language
*[W3C]:  World Wide Web Consortium

A paragraph with @not-an-icon and @not:an-icon and a @fa:star-o icon and an @ion:alert icon.

A simple command `echo $1` and a \n forced return and an escaped \\n return and \prefixed text.

A [Link back to header 1](#custom-id) and some text with a footnote.[^1]

The HTML specification is maintained by the W3C.

An inline link https://src.run that should be transformed into a HTML hyperlink automatically.

This paragraph is special, as it contains a {>pull quote that will be given a special treatment by duplicating the
content in a data-pull-link attribute} which allows you to use special CSS to position the attribute content in whatever
pull quote style you'd like.

Alternatively, this paragraph should not cause a pull quote to be created with only an opening {> and no closing bracket
closing it. Even more, you can escape the pull quote behavior \{>using a forward slash before the opening bracket}. Also,
brackets { without a greater than sign} don't cause pull quotes and escaping the greater than sign {\> works as well.}

---

Apple
:   Pomaceous fruit of plants of the genus Malus in
    the family Rosaceae.

Orange
:   The fruit of an evergreen tree of the genus Citrus.

| Function name | Description                    |
| ------------- | ------------------------------ |
| `help()`      | Display the help window.       |
| `destroy()`   | **Destroy your computer!**     |

> And a quote to finish

[^1]: And that's the footnote.
