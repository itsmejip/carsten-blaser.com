'use strict';

/*
* Class : Point( x coordinate, y coordinate )
* -------------------------------------------
* Represents a single point on the plot.
*/

class Point {

	constructor(x = 0, y = 0) {
		this.x = x;
		/*
			The reason to the following is because we 
			want the origin to be at bottom left corner 
			instead of the top left.	
		*/
		this.y = y;
	}
}

/*
* Class : BezierCurve( Collection of n points for a curve of degree n)
* ------------------------------------------------------------------
* Represents a Bezier curve, the number of points passed in the con-
* structor determine the degree of the curve.
*/

class BezierCurve {

	constructor(points) {

		if ( points instanceof Point ) {
			this.points = [];
			for ( let i = 0; i < arguments.length; i++ ) {
				if ( arguments[i] instanceof Point ) {
					this.points.push(arguments[i]);
				}
			}
		} else if ( typeof points === 'object' ) {
			this.points = points;
		} else {
			this.points = [];
		}

		// Drawing points are the number of points that render the curve, 
		// the more the number of drawing points, smoother the curve.
		this.drawPointCount = 100;
		this.drawingPoints = [];
		//this.calcDrawPoints();
	}

	calcDrawPoints() {
		let interval = 1 / this.drawPointCount;
		let t = interval;

		this.drawingPoints.push(this.calcPoint(0));

		for( let i = 0; i < this.drawPointCount; i++ ) {
			this.drawingPoints.push(this.calcPoint(t));
			t += interval;
		}

	}

	calcPoint(t) {
		// Coordinates calculated using the general formula are relative to 
		// origin at bottom left.
		let x = 0;
		let y = 0;
		let n = this.points.length - 1;
		for ( let i = 0; i <= n; i++ ) {
			let bin = this.coeff(n, i) * Math.pow((1-t), (n-i)) * Math.pow(t, i);
			x += bin * this.points[i].x;
			y += bin * this.points[i].y;
		}

		return (new Point(x, y));
	}

	coeff(n, k) {
		var coeff = 1;
		for ( var x = n-k+1; x <= n; x++ ) coeff *= x;
		for ( x = 1; x <= k; x++ ) coeff /= x;
		return coeff;
	}
}



