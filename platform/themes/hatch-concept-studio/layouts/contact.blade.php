{!! Theme::partial('header') !!}

<div id="main">
    <div class="container pt-5 mt-5" id="contact">
        <div class="row">
            <div class="col-md-7">
                <h2 class="contact_h2">Don't be shy</h2>
                <a class="mailto" href="mailto:info@thisishatch.com">info@thisishatch.com</a>
            </div>
            <div class="col-md-5">
                <div>
                    <div class="dubai-info d-flex justify-content-between mt-5 pb-3">
                        <span>Dubai</span>
                        <span>
                            Office B103, Bldg 6, Dubai Design District, Dubai, UAE<br />
                            <a class="custom-link-footer" href="tel:+97104424779">+971 (04) 4247 795</a>
                        </span>
                    </div>
                    <div class="dubai-info d-flex justify-content-between pt-4" style="border-top: 1px solid #0514f0">
                        <span>Cairo</span>
                        <span>17 Galal Al Din Al Deswqi, Almazah, Heliopolis, Cairo, Egypt</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="container py-3 w-lg-25 w-sm-50 w-md-50 d-flex justify-content-between float-start">
            <a href="#" target="_blank" class="custom-link-footer">
                <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}" alt="" />
                <span>Behance</span>
            </a>
            <a href="#" target="_blank" class="custom-link-footer">
                <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}" alt="" />
                <span>Instagram</span>
            </a>
            <a href="#" target="_blank" class="custom-link-footer active">
                <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}" alt="" />
                <span>Linkedin</span>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

{!! Theme::partial('footer') !!}
