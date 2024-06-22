<!DOCTYPE html>
<html lang="en">
    <body>

        {{-- Header File --}}
        @extends('theme.header')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    {{-- Side-Bar File --}}
                    @extends('theme.sidebar')
                </div>
            </div>
        </div>
        
        {{-- Footer File --}}
        @extends('theme.footer')

    </body>
</html>

