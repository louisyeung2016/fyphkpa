
class ProgressCircle{
	constructor(id){
		this.canvas = document.getElementById(id);
		this.ctx = this.canvas.getContext("2d");
		this.canvasWidth = this.canvas.width;
		this.canvasHeight = this.canvas.height;
		console.log(this.canvasWidth +" : "+ this.canvasHeight);
		
		//attribute
		this.id = id;
		this.thickness = 20;
		this.strokeColor = "#85C1E9";
		this.current_arc_value = 1.5;
		
		//text
		var font_setting = ("bold "+this.canvasWidth/16)+"px Verdana";
		this.ctx.font = font_setting;
		this.ctx.textAlign = "center";
		this.ctx.textBaseline = "middle";
		this.ctx.fillText("0.00%", (this.canvasWidth/2), (this.canvasHeight/2));
	}
	
	drawCircle(){
		//console.log(typeof this.ctx); //object
		//console.log(typeof ProgressCircle.ctx); //undefined
		//console.log(typeof this.constructor.ctx); //undefined
		this.ctx.beginPath();
		this.setThickness(this.thickness);
		this.setStrokeColor(this.strokeColor);
		this.ctx.arc((this.canvasWidth/2),(this.canvasHeight/2),(this.canvasWidth/5),1.5*Math.PI,3.5*Math.PI);
		this.ctx.stroke();
		
	}
	
	makeChange(y, index){
		this.changeValue(this.current_arc_value, y, this.ctx, this.canvas, index);
		this.current_arc_value = y;
	}
	
	setThickness(num){
		this.ctx.lineWidth = num;
		this.thickness = num;
	}
	
	setStrokeColor(code){
		this.ctx.strokeStyle = code;
		this.strokeColor = code;
	}
	
	static sayHello(name){
		console.log("Hello " + name);
	}
	
	static drawArc(x, ctx, canvas){
		var canvasWidth = canvas.width;
		var canvasHeight = canvas.height;
		console.log(canvasWidth +" :: "+ canvasHeight);
		//console.log(typeof ctx); //undefined
		ctx.clearRect(0, 0, canvasWidth,canvasHeight);
		//ctx.clearRect(0, 0, 400, 200);
		ctx.beginPath();
		ctx.arc((canvasWidth/2),(canvasHeight/2),(canvasWidth/5),1.5*Math.PI,x*Math.PI);
		ctx.stroke();
		//var rejusted_x = parseFloat(x-0.005).toFixed(2);
		var rejusted_x = ProgressCircle.roundTo2Decimal(x);
		var num = ProgressCircle.roundTo2Decimal(((rejusted_x-1.5)/2)*100) ;
		
		
		//set color in different levels
		//console.log("HAHA"+parseFloat(num));
		//console.log(typeof parseFloat(num));
		if(parseFloat(num) <= 33.5){
			ctx.strokeStyle = "#EC7063"; //red
		}else if(parseFloat(num) <= 66.5 && parseFloat(num) > 33.5){
			ctx.strokeStyle = "#F5B041"; //yellow
		}else{
			ctx.strokeStyle = "#48C9B0"; //green
		}
		
		ctx.fillText(parseFloat(num).toFixed(2)+"%", (canvasWidth/2), (canvasHeight/2));
	}
	
	static drawArc2(x, ctx, canvas){
		var canvasWidth = canvas.width;
		var canvasHeight = canvas.height;
		console.log(canvasWidth +" :: "+ canvasHeight);
		//console.log(typeof ctx); //undefined
		ctx.clearRect(0, 0, canvasWidth,canvasHeight);
		//ctx.clearRect(0, 0, 400, 200);
		ctx.beginPath();
		ctx.arc((canvasWidth/2),(canvasHeight/2),(canvasWidth/5),1.5*Math.PI,x*Math.PI);
		ctx.stroke();
		//var rejusted_x = parseFloat(x-0.005).toFixed(2);
		var rejusted_x = ProgressCircle.roundTo2Decimal(x);
		var num = ProgressCircle.roundTo2Decimal(((rejusted_x-1.5)/2)*100) ;
		
		
		//set color in different levels
		//console.log("HAHA"+parseFloat(num));
		//console.log(typeof parseFloat(num));

		
		ctx.fillText(parseFloat(num).toFixed(2)+"%", (canvasWidth/2), (canvasHeight/2));
	}
	
	static accAdd(arg1,arg2){ 
		var r1,r2,m; 
		try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0} 
		try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0} 
		m=Math.pow(10,Math.max(r1,r2));
		return (arg1*m+arg2*m)/m;
	} 

	static accSubtr(arg1,arg2){
		var r1,r2,m,n;
		try {
			r1=arg1.toString().split(".")[1].length;
		} catch(e){r1=0}
		try {
			r2=arg2.toString().split(".")[1].length;
		} catch(e){r2=0}
		m=Math.pow(10,Math.max(r1,r2));
		n=(r1>=r2)?r1:r2;
		return ((arg1*m-arg2*m)/m).toFixed(n);
	}
	
	static roundTo2Decimal(arg){
		return (Math.round(arg * 100) / 100);
	}
	
	changeValue(old_arc_value, new_arc_value, ctx, canvas, index){
		if(old_arc_value > new_arc_value){ //--
			var i = setInterval(function(){
				//console.log("new_arc_value: " + new_arc_value);
				old_arc_value = ProgressCircle.accSubtr(old_arc_value,0.01);
				console.log("old_arc_value: " + old_arc_value);
				//ProgressCircle.sayHello("Peter");
				if(index==0){
					ProgressCircle.drawArc2(old_arc_value, ctx, canvas);
				}else if(index==1){
					ProgressCircle.drawArc(old_arc_value, ctx, canvas);
				}
				
				if(old_arc_value <= new_arc_value) {
					clearInterval(i);
					console.log("Finish");
				}
			},10);
		}else if(old_arc_value < new_arc_value){//++
			var i = setInterval(function(){
				//console.log("new_arc_value: " + new_arc_value);
				old_arc_value = ProgressCircle.accAdd(old_arc_value, 0.01);
				console.log("old_arc_value: " + old_arc_value);
				//ProgressCircle.sayHello("Peter");
				if(index==0){
					ProgressCircle.drawArc2(old_arc_value, ctx, canvas);
				}else if(index==1){
					ProgressCircle.drawArc(old_arc_value, ctx, canvas);
				}
				if(old_arc_value >= new_arc_value) {
					clearInterval(i);
					console.log("Finish");
				}
			},10);
		}else{
			//value unchange
		}
	}
}

export {ProgressCircle};