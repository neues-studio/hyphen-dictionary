.. highlight:: html
.. _configuration:

=============
Configuration
=============

Creating the sys folder
-----------------------

Create a sys folder in the TYPO3 backend and add words with
optional word breaks to it. To set the optional word breaks
use `[-]` at the position the words break should be.

**Be aware that the defined words are case-sensitive.**

Using the ViewHelper
--------------------

To add the optional word breaks to a given string (e.g. headline)
use the `HyphenateViewHelper`.::

   <html data-namespace-typo3-fluid="true"
         xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
         xmlns:h="http://typo3.org/ns/NeuesStudio/HyphenDictionary/ViewHelpers">
      <h:format.hyphenate content="{data.header}" />
      or
      <h:format.hyphenate>{data.header}</h:format.hyphenate>
      or
      {data.header -> h:format.hyphenate()}
   </html>

You can use the `minWordLength` argument to define that only words
with that length should be hyphenated.
