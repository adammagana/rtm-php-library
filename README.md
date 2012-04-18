#Remember The Milk
*A PHP Library*

##Description
**Author**: Adam Magaña &lt;adammagana@gmail.com&gt;  
**Last Edit**: April 18th, 2012  
**Version**: 0.0.1

##Usage
###Constructor
```
require('rtm.php');
$rtm = new RTM(APP_KEY, APP_SECRET, PERMISSIONS, FORMAT);
```
<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Default</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>APP_KEY</td>
        <td>string</td>
        <td>none (required)</td>
        <td>Your RTM application's public key.</td>
    </tr>
    <tr>
        <td>APP_SECRET</td>
        <td>string</td>
        <td>none (required)</td>
        <td>Your RTM application's secret key.</td>
    </tr>
    <tr>
        <td>PERMISSIONS</td>
        <td>string</td>
        <td>read</td>
        <td>The RTM permission level your application requests from a user.</td>
    </tr>
    <tr>
        <td>FORMAT</td>
        <td>string</td>
        <td>json</td>
        <td>The RTM API response format. Value can be either 'json' or 'rest'.</td>
    </tr>
</table>

###Generate Authentication URL
```
$authUrl = $rtm->getAuthUrl();
```
The value of `$authUrl` will be a RTM formatted authentication URL containing your API Key, permission level, response format, and signature.

##License 

(The MIT License)

Copyright (c) 2011 Adam Magaña &lt;adammagana@gmail.com&gt;

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.