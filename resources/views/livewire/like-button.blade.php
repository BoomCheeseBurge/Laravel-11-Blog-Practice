<div class="flex justify-start items-center md:gap-1">
    @if ($this->model->isLiked() == true)
        <button wire:click="toggleLike" type="button" 
            class="w-10 h-10 overflow-hidden
                @if($this->is_trashed) 
                    pointer-events-none 
                @endif 
                text-slate-800 dark:text-amber-400" 
            @guest disabled @endguest>
            <svg class="w-24 h-24
                    [&>.confa1]:origin-[276px_246px] [&>.confa2]:origin-[310px_241px] 
                    [&>.confb1]:origin-[195px_232px] [&>.confb2]:origin-[230px_220px] [&>.confb3]:origin-[223px_190px] [&>.confb4]:origin-[262px_188px] [&>.confb5]:origin-[282px_171px] 
                    [&>.confc1]:origin-[175px_183px] [&>.confc2]:origin-[179px_156px] [&>.confc3]:origin-[207px_140px] [&>.confc4]:origin-[213px_120px] 
                    [&>.confd1]:origin-[127px_176px] [&>.confd2]:origin-[133px_118px] [&>.confd3]:origin-[152px_100px]" 
                    version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 800 800" style="enable-background:new 0 0 800 800;" xml:space="preserve">
                {{-- Confetti Body START --}}
                <g class="origin-[200px_50px] translate-y-[2.5rem] rotate-45 translate-x-8">
                    <path class="conf0" d="M131.5,172.6L196,343c2.3,6.1,11,6.1,13.4,0l65.5-170.7L131.5,172.6z"/>
                    <path class="conf1" d="M131.5,172.6L196,343c2.3,6.1,11,6.1,13.4,0l6.7-17.5l-53.6-152.9L131.5,172.6z"/>

                    <path class="conf2" d="M274.2,184.2c-1.8,1.8-4.2,2.9-7,2.9l-129.5,0.4c-5.4,0-9.8-4.4-9.8-9.8c0-5.4,4.4-9.8,9.9-9.9l129.5-0.4
                        c5.4,0,9.8,4.4,9.8,9.8C277,180,275.9,182.5,274.2,184.2z"/>
                    <polygon class="conf3" points="231.5,285.4 174.2,285.5 143.8,205.1 262.7,204.7"/>
                    <path class="conf4" d="M166.3,187.4l-28.6,0.1c-5.4,0-9.8-4.4-9.8-9.8c0-5.4,4.4-9.8,9.9-9.9l24.1-0.1c0,0-2.6,5-1.3,10.6
                        C161.8,183.7,166.3,187.4,166.3,187.4z"/>
                    <ellipse class="conf2" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -89.8523 231.0278)" cx="233.9" cy="224" rx="5.6" ry="5.6"/>
                    <path class="conf5" d="M143.8,205.1l5.4,14.3c6.8-2.1,14.4-0.5,19.7,4.8c7.7,7.7,7.6,20.1-0.1,27.8c-1.7,1.7-3.7,3-5.8,4l11.1,29.4
                        l27.7,0l-28-80.5L143.8,205.1z"/>
                    <path class="conf2" d="M169,224.2c-5.3-5.3-13-6.9-19.7-4.8l13.9,36.7c2.1-1,4.1-2.3,5.8-4C176.6,244.4,176.6,231.9,169,224.2z"/>
                    <ellipse class="conf6" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -119.0946 221.1253)" cx="207.4" cy="254.3" rx="11.3" ry="11.2"/>
                </g>
                {{-- Confetti Body END --}}

                {{-- Confetti Explosion START --}}
                <circle class="-translate-y-18 conf2 confb1" cx="195.2" cy="232.6" r="5.1"/>
                <circle class="-translate-y-18 conf0 confb2" cx="230.8" cy="219.8" r="5.4"/>
                <circle class="-translate-y-18 conf0 confc2" cx="178.9" cy="160.4" r="4.2"/>
                <circle class="-translate-y-18 conf6 confd2" cx="132.8" cy="123.6" r="5.4"/>
                <circle class="-translate-y-18 conf0 confd" cx="151.9" cy="105.1" r="5.4"/>

                <path class="-translate-y-18 conf0 confd1" d="M129.9,176.1l-5.7,1.3c-1.6,0.4-2.2,2.3-1.1,3.5l3.8,4.2c1.1,1.2,3.1,0.8,3.6-0.7l1.9-5.5C132.9,177.3,131.5,175.7,129.9,176.1z"/>
                <path class="-translate-y-18 conf6 confb5" d="M284.5,170.7l-5.4,1.2c-1.5,0.3-2.1,2.2-1,3.3l3.6,3.9c1,1.1,2.9,0.8,3.4-0.7l1.8-5.2C287.4,171.9,286.1,170.4,284.5,170.7z"/>
                <circle class="-translate-y-18 conf6 confc3" cx="206.7" cy="144.4" r="4.5"/>
                <path class="-translate-y-18 conf2 confc1" d="M176.4,192.3h-3.2c-1.6,0-2.9-1.3-2.9-2.9v-3.2c0-1.6,1.3-2.9,2.9-2.9h3.2c1.6,0,2.9,1.3,2.9,2.9v3.2C179.3,191,178,192.3,176.4,192.3z"/>
                <path class="-translate-y-18 conf2 confb4" d="M263.7,197.4h-3.2c-1.6,0-2.9-1.3-2.9-2.9v-3.2c0-1.6,1.3-2.9,2.9-2.9h3.2c1.6,0,2.9,1.3,2.9,2.9v3.2C266.5,196.1,265.2,197.4,263.7,197.4z"/>
                <!-- yellow-strip-1-->
                <path class="-translate-y-18 yellow-strip" d="M179.7,102.4c0,0,6.6,15.3-2.3,25c-8.9,9.7-24.5,9.7-29.7,15.6c-5.2,5.9-0.7,18.6,3.7,28.2c4.5,9.7,2.2,23-10.4,28.2"/>
                <path class="-translate-y-18 yellow-strip" d="M252.2,156.1c0,0-16.9-3.5-28.8,2.4c-11.9,5.9-14.9,17.8-16.4,29c-1.5,11.1-4.3,28.8-31.5,33.4"/>
                <path class="-translate-y-18 conf0 confa1" d="M277.5,254.8h-3.2c-1.6,0-2.9-1.3-2.9-2.9v-3.2c0-1.6,1.3-2.9,2.9-2.9h3.2c1.6,0,2.9,1.3,2.9,2.9v3.2C280.4,253.5,279.1,254.8,277.5,254.8z"/>
                <path class="-translate-y-18 conf3 confc4" d="M215.2,121.3L215.2,121.3c0.3,0.6,0.8,1,1.5,1.1l0,0c1.6,0.2,2.2,2.2,1.1,3.3l0,0c-0.5,0.4-0.7,1.1-0.6,1.7v0c0.3,1.6-1.4,2.8-2.8,2l0,0c-0.6-0.3-1.2-0.3-1.8,0h0c-1.4,0.7-3.1-0.5-2.8-2v0c0.1-0.6-0.1-1.3-0.6-1.7l0,0c-1.1-1.1-0.5-3.1,1.1-3.3l0,0c0.6-0.1,1.2-0.5,1.5-1.1v0C212.5,119.8,214.5,119.8,215.2,121.3z"/>
                <path class="-translate-y-18 conf3 confb3" d="M224.5,191.7L224.5,191.7c0.3,0.6,0.8,1,1.5,1.1l0,0c1.6,0.2,2.2,2.2,1.1,3.3v0c-0.5,0.4-0.7,1.1-0.6,1.7l0,0c0.3,1.6-1.4,2.8-2.8,2h0c-0.6-0.3-1.2-0.3-1.8,0l0,0c-1.4,0.7-3.1-0.5-2.8-2l0,0c0.1-0.6-0.1-1.3-0.6-1.7v0c-1.1-1.1-0.5-3.1,1.1-3.3l0,0c0.6-0.1,1.2-0.5,1.5-1.1l0,0C221.7,190.2,223.8,190.2,224.5,191.7z"/>
                <path class="-translate-y-18 conf3 confa2" d="M312.6,242.1L312.6,242.1c0.3,0.6,0.8,1,1.5,1.1l0,0c1.6,0.2,2.2,2.2,1.1,3.3l0,0c-0.5,0.4-0.7,1.1-0.6,1.7v0c0.3,1.6-1.4,2.8-2.8,2l0,0c-0.6-0.3-1.2-0.3-1.8,0h0c-1.4,0.7-3.1-0.5-2.8-2v0c0.1-0.6-0.1-1.3-0.6-1.7l0,0c-1.1-1.1-0.5-3.1,1.1-3.3l0,0c0.6-0.1,1.2-0.5,1.5-1.1v0C309.9,240.6,311.9,240.6,312.6,242.1z"/>
                <path class="-translate-y-18 yellow-strip" d="M290.7,215.4c0,0-14.4-3.4-22.6,2.7c-8.2,6.2-8.2,23.3-17.1,29.4c-8.9,6.2-19.8-2.7-32.2-4.1c-12.3-1.4-19.2,5.5-20.5,10.9"/>
                {{-- Confetti Explosion END --}}
            </svg>
        </button>
    @else
        <button x-data="{
            /**
             * 
             * @param {bool} isClicked
             */
            triggerConfetti()
            {
                const confettiButton = document.getElementById('confButton{{ $this->likeID }}');
        
                const likeButton = document.getElementById('likeButton{{ $this->likeID }}');

                likeButton.disabled = true;

                confettiButton.classList.add(
                    '[&_.nyellow-strip]:stroke-[#F9B732]',
                    '[&_.nconf0]:fill-[#FC6394]',
                    '[&_.nconf1]:fill-[#EF3C8A]',
                    '[&_.nconf2]:fill-[#5ADAEA]',
                    '[&_.nconf3]:fill-[#974CBE]',
                    '[&_.nconf4]:fill-[#3CBECD]',
                    '[&_.nconf5]:fill-[#813BBE]',
                    '[&_.nconf6]:fill-[#F9B732]',
                );

                confettiButton.classList.add(
                    '[&_.nyellow-strip]:animate-confdash',
                    '[&>#confettiCone]:animate-confetti_cone',
                    '[&>.confa1]:animate-a1',
                    '[&>.confa2]:animate-a2',
                    '[&>.confb1]:animate-b1',
                    '[&>.confb2]:animate-b2',
                    '[&>.confb3]:animate-b3',
                    '[&>.confb4]:animate-b4',
                    '[&>.confb5]:animate-b5',
                    '[&>.confc1]:animate-c1',
                    '[&>.confc2]:animate-c2',
                    '[&>.confc3]:animate-c3',
                    '[&>.confc4]:animate-c4',
                    '[&>.confd1]:animate-d1',
                    '[&>.confd2]:animate-d2',
                    '[&>.confd3]:animate-d3',
                );

                setTimeout(() => {
                    @this.toggleLike();
                }, 500);
                
            },
        }"
            id="likeButton{{ $this->likeID }}" x-on:click="triggerConfetti" type="button" 
            class="w-10 h-10 overflow-hidden
                @if($this->is_trashed) 
                    pointer-events-none 
                @endif 
                text-slate-800 dark:text-amber-400" 
            @guest disabled @endguest>
            <svg id="confButton{{ $this->likeID }}" class="w-24 h-24
                    [&>.confa1]:origin-[276px_246px] [&>.confa2]:origin-[310px_241px] 
                    [&>.confb1]:origin-[195px_232px] [&>.confb2]:origin-[230px_220px] [&>.confb3]:origin-[223px_190px] [&>.confb4]:origin-[262px_188px] [&>.confb5]:origin-[282px_171px] 
                    [&>.confc1]:origin-[175px_183px] [&>.confc2]:origin-[179px_156px] [&>.confc3]:origin-[207px_140px] [&>.confc4]:origin-[213px_120px] 
                    [&>.confd1]:origin-[127px_176px] [&>.confd2]:origin-[133px_118px] [&>.confd3]:origin-[152px_100px]" 
                    version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 800 800" style="enable-background:new 0 0 800 800;" xml:space="preserve">
                {{-- Confetti Body START --}}
                <g id="confettiCone" class="origin-[200px_50px] translate-y-[2.5rem] rotate-45 translate-x-8">
                    <path class="nconf0" d="M131.5,172.6L196,343c2.3,6.1,11,6.1,13.4,0l65.5-170.7L131.5,172.6z"/>
                    <path class="nconf1" d="M131.5,172.6L196,343c2.3,6.1,11,6.1,13.4,0l6.7-17.5l-53.6-152.9L131.5,172.6z"/>

                    <path class="nconf2" d="M274.2,184.2c-1.8,1.8-4.2,2.9-7,2.9l-129.5,0.4c-5.4,0-9.8-4.4-9.8-9.8c0-5.4,4.4-9.8,9.9-9.9l129.5-0.4
                        c5.4,0,9.8,4.4,9.8,9.8C277,180,275.9,182.5,274.2,184.2z"/>
                    <polygon class="nconf3" points="231.5,285.4 174.2,285.5 143.8,205.1 262.7,204.7"/>
                    <path class="nconf4" d="M166.3,187.4l-28.6,0.1c-5.4,0-9.8-4.4-9.8-9.8c0-5.4,4.4-9.8,9.9-9.9l24.1-0.1c0,0-2.6,5-1.3,10.6
                        C161.8,183.7,166.3,187.4,166.3,187.4z"/>
                    <ellipse class="nconf2" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -89.8523 231.0278)" cx="233.9" cy="224" rx="5.6" ry="5.6"/>
                    <path class="nconf5" d="M143.8,205.1l5.4,14.3c6.8-2.1,14.4-0.5,19.7,4.8c7.7,7.7,7.6,20.1-0.1,27.8c-1.7,1.7-3.7,3-5.8,4l11.1,29.4
                        l27.7,0l-28-80.5L143.8,205.1z"/>
                    <path class="nconf2" d="M169,224.2c-5.3-5.3-13-6.9-19.7-4.8l13.9,36.7c2.1-1,4.1-2.3,5.8-4C176.6,244.4,176.6,231.9,169,224.2z"/>
                    <ellipse class="nconf6" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -119.0946 221.1253)" cx="207.4" cy="254.3" rx="11.3" ry="11.2"/>
                </g>
                {{-- Confetti Body END --}}

                {{-- Confetti Explosion START --}}
                <circle class="-translate-y-18 confb1 nconf2" cx="195.2" cy="232.6" r="5.1"/>
                <circle class="-translate-y-18 confb2 nconf0" cx="230.8" cy="219.8" r="5.4"/>
                <circle class="-translate-y-18 confc2 nconf0" cx="178.9" cy="160.4" r="4.2"/>
                <circle class="-translate-y-18 confd2 nconf6" cx="132.8" cy="123.6" r="5.4"/>
                <circle class="-translate-y-18 confd nconf0" cx="151.9" cy="105.1" r="5.4"/>

                <path class="-translate-y-18 confd1 nconf0" d="M129.9,176.1l-5.7,1.3c-1.6,0.4-2.2,2.3-1.1,3.5l3.8,4.2c1.1,1.2,3.1,0.8,3.6-0.7l1.9-5.5C132.9,177.3,131.5,175.7,129.9,176.1z"/>
                <path class="-translate-y-18 confb5 nconf6" d="M284.5,170.7l-5.4,1.2c-1.5,0.3-2.1,2.2-1,3.3l3.6,3.9c1,1.1,2.9,0.8,3.4-0.7l1.8-5.2C287.4,171.9,286.1,170.4,284.5,170.7z"/>
                <circle class="-translate-y-18 confc3 nconf6" cx="206.7" cy="144.4" r="4.5"/>
                <path class="-translate-y-18 confc1 nconf2" d="M176.4,192.3h-3.2c-1.6,0-2.9-1.3-2.9-2.9v-3.2c0-1.6,1.3-2.9,2.9-2.9h3.2c1.6,0,2.9,1.3,2.9,2.9v3.2C179.3,191,178,192.3,176.4,192.3z"/>
                <path class="-translate-y-18 confb4 nconf2" d="M263.7,197.4h-3.2c-1.6,0-2.9-1.3-2.9-2.9v-3.2c0-1.6,1.3-2.9,2.9-2.9h3.2c1.6,0,2.9,1.3,2.9,2.9v3.2C266.5,196.1,265.2,197.4,263.7,197.4z"/>
                <!-- yellow-strip-1-->
                <path class="-translate-y-18 nyellow-strip" d="M179.7,102.4c0,0,6.6,15.3-2.3,25c-8.9,9.7-24.5,9.7-29.7,15.6c-5.2,5.9-0.7,18.6,3.7,28.2c4.5,9.7,2.2,23-10.4,28.2"/>
                <path class="-translate-y-18 nyellow-strip" d="M252.2,156.1c0,0-16.9-3.5-28.8,2.4c-11.9,5.9-14.9,17.8-16.4,29c-1.5,11.1-4.3,28.8-31.5,33.4"/>
                <path class="-translate-y-18 confa1 nconf0" d="M277.5,254.8h-3.2c-1.6,0-2.9-1.3-2.9-2.9v-3.2c0-1.6,1.3-2.9,2.9-2.9h3.2c1.6,0,2.9,1.3,2.9,2.9v3.2C280.4,253.5,279.1,254.8,277.5,254.8z"/>
                <path class="-translate-y-18 confc4 nconf3" d="M215.2,121.3L215.2,121.3c0.3,0.6,0.8,1,1.5,1.1l0,0c1.6,0.2,2.2,2.2,1.1,3.3l0,0c-0.5,0.4-0.7,1.1-0.6,1.7v0c0.3,1.6-1.4,2.8-2.8,2l0,0c-0.6-0.3-1.2-0.3-1.8,0h0c-1.4,0.7-3.1-0.5-2.8-2v0c0.1-0.6-0.1-1.3-0.6-1.7l0,0c-1.1-1.1-0.5-3.1,1.1-3.3l0,0c0.6-0.1,1.2-0.5,1.5-1.1v0C212.5,119.8,214.5,119.8,215.2,121.3z"/>
                <path class="-translate-y-18 confb3 nconf3" d="M224.5,191.7L224.5,191.7c0.3,0.6,0.8,1,1.5,1.1l0,0c1.6,0.2,2.2,2.2,1.1,3.3v0c-0.5,0.4-0.7,1.1-0.6,1.7l0,0c0.3,1.6-1.4,2.8-2.8,2h0c-0.6-0.3-1.2-0.3-1.8,0l0,0c-1.4,0.7-3.1-0.5-2.8-2l0,0c0.1-0.6-0.1-1.3-0.6-1.7v0c-1.1-1.1-0.5-3.1,1.1-3.3l0,0c0.6-0.1,1.2-0.5,1.5-1.1l0,0C221.7,190.2,223.8,190.2,224.5,191.7z"/>
                <path class="-translate-y-18 confa2 nconf3" d="M312.6,242.1L312.6,242.1c0.3,0.6,0.8,1,1.5,1.1l0,0c1.6,0.2,2.2,2.2,1.1,3.3l0,0c-0.5,0.4-0.7,1.1-0.6,1.7v0c0.3,1.6-1.4,2.8-2.8,2l0,0c-0.6-0.3-1.2-0.3-1.8,0h0c-1.4,0.7-3.1-0.5-2.8-2v0c0.1-0.6-0.1-1.3-0.6-1.7l0,0c-1.1-1.1-0.5-3.1,1.1-3.3l0,0c0.6-0.1,1.2-0.5,1.5-1.1v0C309.9,240.6,311.9,240.6,312.6,242.1z"/>
                <path class="-translate-y-18 nyellow-strip" d="M290.7,215.4c0,0-14.4-3.4-22.6,2.7c-8.2,6.2-8.2,23.3-17.1,29.4c-8.9,6.2-19.8-2.7-32.2-4.1c-12.3-1.4-19.2,5.5-20.5,10.9"/>
                {{-- Confetti Explosion END --}}
            </svg>
        </button>
    @endif

    @if ($this->set_icon)
        <h5 class="hidden ml-2 text-sm font-normal leading-snug text-slate-500 dark:text-slate-300 md:block">Cheers</h5>
    @endif
    
    <div class="p-2 text-base font-medium text-slate-800 dark:text-slate-100">
        {{ $this->countLikes() }}
    </div>
</div>
