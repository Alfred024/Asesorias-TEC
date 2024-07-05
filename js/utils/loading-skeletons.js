function show_loading_skeletons() {
    let loadingCards = '';
    
    for (let vueltas=0; vueltas<4; vueltas++) {
        loadingCards +=`
            <div>
            <div 
                class="Subject-Card anchor-default margin-right-10 bg-white border-radius-30 overflow-hidden">
                <div class="flex-column justify-between padding-10" style="height: 80%;">
                    <p class="width-100 bg-light-gray border-radius-10" style="height:20px;"></p>
                    <div class="flex justify-between">
                        <p class="width-40 bg-light-gray border-radius-10" style="height:20px;"></p>
                        <div class="flex">
                            <div 
                                style="width: 15px; height: 15px;"
                                class="border-radius-full margin-right-10 bg-light-gray">
                            </div>
                            <div 
                                style="width: 15px; height: 15px;"
                                class="border-radius-full margin-right-10 bg-light-gray">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-secondary-blue" style="height: 20%;">
                </div>
            </div>
            </div>
        `;
    }

    SubjectsCardsContainerId.innerHTML = loadingCards;
    // SubjectsCardsContainerId.appendChild = loadingCards;
}