# typoscriptconditions

this extensions aims to be a collection of useful custom TypoScript Condtions.
We have
 
 - PageTranslationsCount. Usage example:
  
        [ElementareTeilchen\Typoscriptconditions\PageTranslationsCount < 1]
            // do something fancy if current page was not yet translated to any other language besides default language
        [end]