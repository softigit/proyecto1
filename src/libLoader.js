(function() {
   if (emb.features.STUB_OUT_GOOGLE_MAPS) {
     emb.geocoder = {
       geocode: function( addressData, handler ) {
         emb.console.info('stubbed geocode');

         setTimeout(function() {
           google = {
             maps: {
               GeocoderStatus: { OK: true }
             }
           };
           var responseData = [{ geometry: { location: {
                                               lat: function() { return 40.714269; },
                                               lng: function() { return -74.005972; }
                                             }}
                               }];

           handler( responseData, true );
         }, 500 );
       },
       getCurrentPosition: function() {
         emb.console.info('stubbed getCurrentPosition');
       }
     };
  }
}());
