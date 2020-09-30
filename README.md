# TYPO3 Extension `hyphen_dictionary`

## 1 Motivation

In the past years we have created many TYPO3 websites
with mobile versions. Depending on the design, the mobile
versions often had headlines with quite a large font size.
Using long words leads to either cut of headlines or weird
word breaks because of the browsers decision where to break
the word. To also support defining optional word breaks (&shy;)
for header fields, we have created this extension.

## 2 What is does

This extension allows editors to define a dictionary of word
and where to put optionally word breaks.

Using a ViewHelper in fluid templates replaces the given input
with in the dictionary defined words.

## 3 How to use

Install this extension with

`composer reg neues-studio/hyphen-dictionary`

### 3.1 Creating the dictionary

Create a sys folder in the TYPO3 backend and add words with
optional word breaks to it. To set the optional word breaks
use `[-]` at the position the words break should be.

**Be aware that the defined words are case-sensitive.**

### 3.2 Using the ViewHelper

To add the optional word breaks to a given string (e.g. headline)
use the `HyphenateViewHelper`.

**Example**
```
<html data-namespace-typo3-fluid="true"
      xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:h="http://typo3.org/ns/NeuesStudio/HyphenDictionary/ViewHelpers">
<h:format.hyphenate content="{data.header}" />
or
<h:format.hyphenate>{data.header}</h:format.hyphenate>
or
{data.header -> h:format.hyphenate()}
</html>
```

You can use the `minWordLength` argument to define that only words
with that length should be hyphenated.
