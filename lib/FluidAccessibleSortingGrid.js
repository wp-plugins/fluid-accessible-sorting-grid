var demo = demo || {};
 
demo.initGridReorderer = function () {
    return fluid.reorderGrid('.demoSelector-gridReorderer-alphabetGrid', {
        styles: {
            dragging: "demo-gridReorderer-dragging",
            avatar: "demo-gridReorderer-avatar",
            selected: "demo-gridReorderer-selected",
            dropMarker: "demo-gridReorderer-dropMarker"
        },
        disableWrap: true
    });
};


