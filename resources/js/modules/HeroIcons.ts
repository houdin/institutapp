const Icons: Object = {
    assistance: "Phone",
    star: "Star",

    "effets-speciaux": "Bolt",
    "3d-modelisation": "Cube",
    "motion-design-graphics": "ChartBar",
    animation: "ArrowTrendingUp",
    "tv-broadcast": "Tv",
    storyboard: "PaintBrush",
    architecture: "BuildingOffice",
    "web-applications": "GlobeAlt",
    marketing: "Megaphone",
    "devis/type": "DocumentText",

    boutique: "ShoppingCart",
    produit: "ShoppingCart",
    plugins: "ArrowRightCircle",
    "modeles-3d": "Cube",
    applications: "DevicePhoneMobile",

    formations: "Bookmark",
    tutoriels: "BookmarkSquare",
    cursus: "Share",
    support: "QuestionMarkCircle",
    "tips-tricks": "CommandLine",

    team: "UserGroup",
    recrutement: "UserPlus",
    challenge: "Trophy",
    blog: "PencilSquare",
    article: "PencilSquare",
    forums: "ChatBubbleLeftRight",
    contact: "Phone",
    success: "CheckCircle",
    danger: "ExclamationCircle",
    warning: "ExclamationTriangle",
};
const getHeroIcon = (text: String) => {
    let icon = "";
    Object.getOwnPropertyNames(Icons).forEach((val, idx, array) => {
        if (val.includes(text.toLowerCase())) {
            icon = Icons[val] + "Icon";
        }
    });
    return icon;
};
export default getHeroIcon;
